<?php
namespace App\Http\Controllers\MyApp; 
use Illuminate\Http\Request; 

class AccountController extends BaseController{ 

    public function login_page(Request $request){
         
        return $this->appView($request, 'webpage.login-page', ['title'=>'Login']);
    }
    
 
}