<?php

namespace App\Services;

use App\Dto\Filter;
use App\Dto\WebRequest;
use App\Dto\WebResponse;
use App\Models\FoodTaskGroupMember;
use App\Models\Menu;
use App\Models\Page;
use App\Repositories\PageRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class ComponentService {

    protected ProfileRepository $profile_repository;
    protected PageRepository $page_repository;
    protected WebConfigService $webConfigService;


    public function __construct(ProfileRepository $profile_repository, PageRepository $page_repository , WebConfigService $webConfigService)
    {
        $this->profile_repository = $profile_repository;
        $this->page_repository =  $page_repository;
        $this->webConfigService = $webConfigService;
    }

    public function getFoodTaskGroupMember(){
        $filter = new Filter();
        $filter->orderBy = "sequence";

        $result = $this->webConfigService->entityRepository->filter(new ReflectionClass(FoodTaskGroupMember::class), $filter, true);
        return $result["resultList"];
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
			$this->webConfigService->entityRepository->updateWithKeys($cls, $id, ["sequence"=>$sequence]);
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