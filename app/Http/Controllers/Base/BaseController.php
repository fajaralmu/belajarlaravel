<?php
namespace App\Http\Controllers\Base;

use App\Dto\PageModel;
use App\Http\Controllers\Controller;
use App\Models\AppProfile;
use App\Models\Page;
use Illuminate\Http\Request;

class BaseController extends Controller{


    public function appView(Request $request, string $view ,   $data = [], $mergeData = []){
        out("URL:",$request->url());
       
        $pageModel = $this->fillData($data,  $request); 
        
        return view($view, $pageModel, $mergeData);
    }

    function getProfile(){
        $profile_code = config("app.general.APP_CODE");
        $profile = AppProfile::where('app_code',  $profile_code)  ->first(); 
        
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

        $pageModel->context_path  =  $request->url();
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
 