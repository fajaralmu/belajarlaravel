<?php
namespace App\Http\Controllers\Base;
 
use Illuminate\Http\Request;

class MainController extends BaseController
{
  
    public function __construct()
    {
        //$this->middleware('guest');
        out("-----MainController------");
    }

    public function index(Request $request){
        
        return $this->appView($request, 'index', ['title'=>'Testing']);
    }

}

 