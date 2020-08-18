<?php

namespace App\Services;

use App\Dto\Filter;
use App\Dto\WebRequest;
use App\Dto\WebResponse;
use App\Models\FoodTaskGroupMember;
use App\Models\Menu;
use App\Models\Page;
use App\Models\ScheduledFoodTaskGroup;
use App\Repositories\EntityRepository;
use App\Repositories\MealTaskGroupMemberRepository;
use App\Repositories\PageRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;
use Throwable;

class ComponentService {

    protected ProfileRepository $profile_repository;
    protected PageRepository $page_repository;
    protected WebConfigService $webConfigService;
    protected MealTaskGroupMemberRepository $mealTaskGroupMemberRepo;
    protected EntityRepository $entityRepositry;
    protected EntityService $entityService;


    public function __construct(ProfileRepository $profile_repository, PageRepository $page_repository , WebConfigService $webConfigService, MealTaskGroupMemberRepository $mealTaskGroupMemberRepo)
    {
        $this->profile_repository = $profile_repository;
        $this->page_repository =  $page_repository;
        $this->mealTaskGroupMemberRepo = $mealTaskGroupMemberRepo;
        $this->webConfigService = $webConfigService;
    }

    public function setEntityRepoAndEntitySvc(EntityRepository $repo, EntityService $svc){
        $this->entityService = $svc;
        $this->entityRepositry = $repo;
    }

    public function getFoodTaskGroupMember(){
        $filter = new Filter();
        $filter->orderBy = "sequence";

        $result = $this->webConfigService->entityRepository->filter(new ReflectionClass(FoodTaskGroupMember::class), $filter, true);
        return $result["resultList"];
    }


    public function createMealSchedule(WebRequest $webRequest, int $beginningIndex, Request $request){
        $allGroups = $this->mealTaskGroupMemberRepo->getAll();
        $dbRecord = $this->entityRepositry->findById(new ReflectionClass(FoodTaskGroupMember::class), $beginningIndex);
        if(is_null($dbRecord)){
            return WebResponse::failed("Selected record not FOUND");
        } 
        $groupMemberCount = sizeof($allGroups);
        $filter = $webRequest->filter;
		$dayCount =  cal_days_in_month(CAL_GREGORIAN, $filter->month,  $filter->year);
        $sequenceNumber =  $dbRecord->sequence;
        $mealtimes = ["BREAKFAST","LUNCH","DINNER"];
        $this->clearDataForSelectedMonth($filter, $request); 
        out("month:".$filter->month."dayCount: ". $dayCount );

		for ($i = 1; $i <= $dayCount; $i++) {

			for ($j = 0; $j < sizeof($mealtimes); $j++, $sequenceNumber++) {

				if ($sequenceNumber == $groupMemberCount) {
					$sequenceNumber = 0;
				}
                try {
                    $mealtime = $mealtimes[$j];
                    $newSchedule = new ScheduledFoodTaskGroup();
                    $newSchedule->day=($i);
                    $newSchedule->month=($filter->month);
                    $newSchedule->year=($filter->year);
                    $newSchedule->meal_time = ($mealtime);
                    $newSchedule->group_member_id = $allGroups[$sequenceNumber]["id"]; 
					$this->entityService->doAdd("scheduledfoodtaskgroup", $newSchedule);
					 
				} catch (Throwable $e) {
					 out("Error", $e->getMessage());
				}
				 

			}

		}

        $response = new WebResponse();
        return $response; 
    }

    private function clearDataForSelectedMonth(Filter $filter, Request $httpReq) {
        $month = $filter->month;
        $year = $filter->year;
        $class = new ReflectionClass(ScheduledFoodTaskGroup::class);
		$existings = $this->entityRepositry->findWithKeys(  $class, [ "month"=>$month, "year"=>$year]);

		if ( sizeof($existings ) > 0) {
			 
			foreach ($existings as $existing) {
			    $this->entityRepositry->deleteById($class, $existing['id']); 
			}
		} else {
			 
		}
	}

    public function saveEntitySequence(WebRequest $request, string $entityName) {

		$orderedEntities = $request->orderedEntities;
        $cls = $this->webConfigService->getConfig($entityName);  

        for ($i = 0; $i < sizeof($orderedEntities ); $i++) {
            $obj = $orderedEntities [$i];
            $this->updateSequence($i, $obj['id'], $cls);
        }

        $response = new WebResponse();
        return $response; 
    }
    
    private function updateSequence(int $sequence, $id, ReflectionClass $cls){
        
        $dbRecord = $this->webConfigService->findById($cls, $id);
		if ($dbRecord != null) {
			//must have sequence
			$dbRecord->sequence= $sequence ;
			$this->entityRepository->updateWithKeys($cls, $id, ["sequence"=>$sequence]);
		}
    } 

    public function getProfile(){
        $profile_code = config("app.general.APP_CODE");
        return $this->profile_repository->getOneBy("app_code", $profile_code);
    }

    public function getPages(Request $request){
        out("USER: ", $request->user());
        $pages = array();
        if(Auth::check()){
            $pages = Page::orderBy('sequence', 'asc')  ->get()->toArray();  
        }else{
            $pages = Page::where('authorized', 0) ->orderBy('sequence', 'asc')  ->get()->toArray();  
        }
       
        return  $pages;
    }

    public function getPageAndMenus(string $page_code){
        $page = $this->page_repository->getFirstByCode($page_code); 
        if(is_null($page) == false){
            $menus = Menu::where('page_id', $page->id)->get()->toArray();
            $page->menus = $menus;
           
        } else{
            out("page with code ".$page_code." is NULL");
        }
        return $page;
    }

}