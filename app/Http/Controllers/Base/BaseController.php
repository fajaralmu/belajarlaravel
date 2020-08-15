<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\AppProfile;
use Illuminate\Http\Request;

class BaseController extends Controller{


    public function appView(Request $request, $view = null, $data = [], $mergeData = []){
        out("URL:",$request->url());
       
        $data = $this->fillData($data,  $request); 
        
        return view($view, $data, $mergeData);
    }

    function getProfile(){
        $profile_code = config("app.general.APP_CODE");
        $profile = AppProfile::where('app_code',  $profile_code)  ->first(); 
        
        return $profile;
    }

    function fillData($data, Request  $request){
        $data  [ 'context_path']  =  $request->url();
        $data [ 'page_token'] = '12345';
        $data [ 'registered_request_id'] = '12345';
        $data [ 'request_id'] = '12345'; 
        $data [ 'profile'] = $this->getProfile();
        $data ['year'] =date("Y");

        if(!isset($data['title'])){
            $data['title'] = "Default Page";
        }

        return $data;
    }
}
 