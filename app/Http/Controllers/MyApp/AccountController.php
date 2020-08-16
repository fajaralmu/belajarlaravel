<?php
namespace App\Http\Controllers\MyApp;

use App\Services\AccountService;
use App\Services\ComponentService;
use Illuminate\Http\Request; 

class AccountController extends BaseController{ 

    protected AccountService $account_service;

    public function __construct(ComponentService $component_service,  AccountService $account_service)
    {  
        $this->account_service = $account_service;
        parent::__construct($component_service); 
    }

    public function login_page(Request $request){ 
        return $this->appView($request, 'webpage.login-page', ['title'=>'Login']);
    }

    public function logout(Request $request){
        $this->account_service->do_logout($request);
        return  redirect()->route('login');
    }

}