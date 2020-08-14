<?php
namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller{


    public function appView(Request $request, $view = null, $data = [], $mergeData = []){
        out("URL:",$request->url());
       
        $data = $this->fillData($data,  $request); 
        
        return view($view, $data, $mergeData);
    }

    function getProfile(){
        $profile = new Profile;
        $profile->name = "My Dormitory";
        $profile->short_description = "my awesome dormitory";

        return  $profile;
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

class Profile {
    public $name, $short_description;

}