<?php 
namespace App\Services;

use App\Dto\WebResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountService {

    /** 
     *  
     */
    public function loginAttemp(Request $request){
        $user = $request->input("user"); 
        $response = new WebResponse();
        
        if (Auth::attempt(['username' =>$user['username'], 'password' => $user['password']])) {
            // The user is active, not suspended, and exists.  
        }else{ 
            $response->code = "01";
            $response->message = "FAILED";
        }
        return $response;
    }

}

?>