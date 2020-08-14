<?php
namespace App\Http\Controllers\Base;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
  
    public function __construct()
    {
        //$this->middleware('guest');
        out("-----MainController------");
    }

    public function index(Request $request){

        return view('welcome');
    }

}

 