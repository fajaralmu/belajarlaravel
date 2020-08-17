<?php
namespace App\Http\Controllers\MyApp;

use App\Dto\PageModel;
use App\Http\Controllers\Controller;  
use App\Services\ComponentService;
use App\Services\WebConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class BaseController extends Controller{

    protected ComponentService $component_service;
    protected WebConfigService $web_config_service;
    
    public function __construct(ComponentService $component_service,  WebConfigService $web_config_service)
    {  
        $this->component_service = $component_service;  
        $this->web_config_service = $web_config_service;
        $this->postConstruct();
    }

    /**
     * can be overriden
     */
    protected function postConstruct(){  }

    protected function clearLatestUrl(Request $request){
        $request->session()->put("latest_request_url", null);
    }

    public function error(Request $request, string $message){
        return response()->json(
            [
                "title"=>"Error",
                "message"=>$message
            ]
        )->setStatusCode(400);
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
        $pageModel = new PageModel();

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
        
        //Additional resouce paths
        if(array_has($data,"additional_style_paths")){
            $pageModel->additional_style_paths = $data ["additional_style_paths"];
        }
        if(array_has($data,"additional_script_paths")){
            $pageModel->additional_script_paths = $data ["additional_script_paths"];
        }

        return $this->toArray($pageModel, $data);
    }
}
 