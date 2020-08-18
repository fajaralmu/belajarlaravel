<?php
namespace App\Http\Controllers\MyApp;
 
use Illuminate\Http\Request;

class MainController extends BaseController
{
   
    public function index(Request $request){
        try{
            return $this->appView($request, 'index', ['title'=>'My Dormitory']);
        } catch (\Throwable $th) {
            return $this->errorPage($request,$th ); 
        }
    }

}

 