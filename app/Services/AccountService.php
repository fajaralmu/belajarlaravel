<?php 
namespace App\Services;

use App\Dto\WebRequest;
use App\Dto\WebResponse;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountService {

    protected UserRepository $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function checkUsername(WebRequest $webRequest):WebResponse{
        if(!isset($webRequest->username)){
            return WebResponse::failed("Input not complete");
        }
        $username = $webRequest->username;
        $response = new WebResponse();
        if(!$this->user_repository->checkUsername($username)){
            $response->code = "01";
            $response->message = "Username Unavailable";
        }else{
            $response->message = "Username Available";
        }
        return $response;

    }

    public function register(WebRequest $webRequest):WebResponse {
        $response = new WebResponse();
        $user = $webRequest->user;
        $user->password = Hash::make($user->password);
        $this->user_repository->saveUser($user);
        return  $response;

    }

    function array_to_object($obj_name, $array){
        $obj = new $obj_name();

        foreach($array as $key => $value){
            $obj->$key = $value;
        }

        return $obj;
    }

    public function do_logout(Request $request):void{
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
        
        
        if ( Auth::attempt($cred)) {
           
            out("SUCCESS LOGIN: ", Auth::user());
            out("Auth::name: ", Auth::getName());
            out($request->session()->get(Auth::getName()));

            $token = Str::random(60);
            $hashedToken = hash('sha256', $token); 
            $this->user_repository->updateApiToken(Auth::user()->id, $hashedToken);
             
            $request->session()->put('api_token', $hashedToken);
        }else{ 
            $response->code = "01";
            $response->message = "FAILED";
        }
        return $response;
    }

}

?>