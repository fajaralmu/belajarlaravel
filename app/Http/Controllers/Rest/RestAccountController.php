<?php
namespace App\Http\Controllers\Rest;

use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestAccountController extends BaseRestController {
    protected AccountService $account_service;

    public function __construct( AccountService $account_service)
    {
        $this->account_service = $account_service;
        parent::__construct();
    }

    public function checkusername(Request $request){ 

        $webRequest = $this->getWebRequest($request); 
        $response = $this->account_service->checkUsername($webRequest);
        return $this->json_response($response);
    }

    public function register(Request $request){ 
        try{
            $webRequest = $this->getWebRequest($request); 
            $response = $this->account_service->register($webRequest);
            return $this->json_response($response);
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
    }

    public function login(Request $request){ 
        try{
            $webResponse = $this->account_service->loginAttemp($request); 
            $header = null;
            if($webResponse->code == "00"){
                $header = ["location"=>$request->session()->get("latest_request_url")];
            }

            return $this->json_response($webResponse,  $header);
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
    }
    protected function guard()
    {
        return Auth::guard('web');
    }
 
}