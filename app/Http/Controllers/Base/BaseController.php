<?php
namespace App\Http\Controllers\Base;

use App\Dto\PageModel;
use App\Http\Controllers\Controller; 
use App\Models\Page;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class BaseController extends Controller{

    protected ProfileRepository $profile_repository;

    public function __construct(ProfileRepository $profile_repository)
    {
        out("__construct BASE CONTROLLER__");
        $this->profile_repository = $profile_repository;
    }


    public function appView(Request $request, string $view ,   $data = [], $mergeData = []){
        out("URL:",$request->url());
       
        $pageModel = $this->fillData($data,  $request); 
        
        return view($view, $pageModel, $mergeData);
    }

    function getProfile(){
        $profile_code = config("app.general.APP_CODE");
        $profile = $this->profile_repository->getByCode($profile_code);
        
        return $profile;
    }
     
    function toArray($obj, $arr){
        foreach($obj as $key=>$value){
            $arr[$key] = $value;
        } 
        return $arr;
    }

    function fillData(  $data = [], Request  $request){
        $pageModel = new PageModel;

        $pageModel->context_path  = URL::to("");
        $pageModel->page_token = '12345';
        $pageModel->registered_request_id = '12345';
        $pageModel->request_id = '12345'; 
        $pageModel->profile = $this->getProfile();
        $pageModel->year = date("Y");

        $pages = Page::where('authorized', 0)
            ->orderBy('sequence', 'asc') 
            ->get()->toArray(); 
        $pageModel->pages = $pages;
        if(!isset($data['title'])){
            $pageModel->title = "Default Page";
        }
        
        return $this->toArray($pageModel, $data);
    }
}
 