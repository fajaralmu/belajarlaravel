<?php
namespace App\Http\Controllers\MyApp;

use App\Dto\PageModel;
use App\Http\Controllers\Controller;  
use App\Services\ComponentService;
use App\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class BaseController extends Controller{

    protected ComponentService $component_service;
    
    public function __construct(ComponentService $component_service)
    {  
        $this->component_service = $component_service;
        $this->middleware(function ($request, $next) {
            $u = Auth::user();
            out("AUTH USER: ", $u);
            return $next($request);
        });
        
    }


    public function appView(Request $request, string $view ,   $data = [], $mergeData = []){
        out("URL:",$request->url());
       
        $pageModel = $this->fillData($data,  $request); 
        
        return view($view, $pageModel, $mergeData);
    }

    function getProfile(){
        
        $profile = $this->component_service->getProfile();
        
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
        
        if(Auth::user()!=null){ 
            $pageModel->user = Auth::user();
            $pageModel->authenticated = true;
        }

        $pages = $this->component_service->getPages($request);
        $pageModel->pages = $pages;
        if(!isset($data['title'])){
            $pageModel->title = "Default Page";
        }
        
        return $this->toArray($pageModel, $data);
    }
}
 