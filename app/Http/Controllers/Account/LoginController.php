<?php
namespace App\Http\Controllers\Account;
use App\Http\Controllers\Base\BaseController;
use App\Services\AccountService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends BaseController{



    public function index(Request $request){
        // $this->fakeUser();
        return $this->appView($request, 'webpage.login-page', ['title'=>'Login']);
    }
    
 
}