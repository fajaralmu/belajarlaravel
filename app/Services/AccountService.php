<?php 
namespace App\Services;

use App\Dto\WebResponse;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountService {

    protected UserRepository $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    function array_to_object($obj_name, $array){
        $obj = new $obj_name();

        foreach($array as $key => $value){
            $obj->$key = $value;
        }

        return $obj;
    }

    public function do_logout(Request $request){
        Auth::logout();
        out("logged out");
    }

    /** 
     *  
     */
    public function loginAttemp(Request $request){
        $user = $request->input("user"); 
        $response = new WebResponse();
        $cred= ['username' =>$user['username'], 'password' => $user['password']];
        
        if ( Auth::attempt(['username' =>$user['username'], 'password' => $user['password']])) {
           
            out("SUCCESS LOGIN: ", Auth::user());
            out("Auth::name: ", Auth::getName());
            out($request->session()->get(Auth::getName()));
        }else{ 
            $response->code = "01";
            $response->message = "FAILED";
        }
        return $response;
    }

}

?>