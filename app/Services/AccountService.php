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

    /** 
     *  
     */
    public function loginAttemp(Request $request){
        $user = $request->input("user"); 
        $response = new WebResponse();
        $cred= ['username' =>$user['username'], 'password' => $user['password']];
        //auth('web')->attempt($cred);
        if ( Auth::attempt(['username' =>$user['username'], 'password' => $user['password']])) {
            // The user is active, not suspended, and exists.  
            // $user = $this->user_repository->getByUsername($user['username']);
            // $id = $user['id'];
            // out("login using id: ", $id);
            // Auth::loginUsingId($id);
            // Auth::check(); 
            out("Auth::guard('web'): ", Auth::guard('web')->user());
            // Auth::login($this->array_to_object("App\User", $user));

        }else{ 
            $response->code = "01";
            $response->message = "FAILED";
        }
        return $response;
    }

}

?>