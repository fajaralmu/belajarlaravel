<?php
namespace App\Http\Controllers\MyApp;
 
use Illuminate\Http\Request;

class MainController extends BaseController
{
   
    public function index(Request $request){
        
        return $this->appView($request, 'index', ['title'=>'Testing']);
    }

}

 