<?php
namespace App\Http\Controllers\Account;
use App\Http\Controllers\Base\BaseController;
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

    function fakeUser(){
        $user = new User();

$user->username = 'admin';

$user->password = Hash::make('123');
$user->display_name = "Fajar AM";
$user->role_id = 1;

$user->save();
    }
    public function login(Request $request){
       // DB::enableQueryLog();
        $user = $request->input("user"); 
        
        out("Attempt to login", $user['username'], $user['password']);
        if (Auth::attempt(['username' =>$user['username'], 'password' => $user['password']])) {
            // The user is active, not suspended, and exists.
            out("AUTH SUCCESS");
            return response()->json([
                'code'=>'00',
                'message'=>'success'
            ]);
        }else{
            out("AUTH FAILED");
            return response()->json([
                'code'=>'01',
                'message'=>'Failed'
            ]);
        }
      //  dd(DB::getQueryLog());
    }
}