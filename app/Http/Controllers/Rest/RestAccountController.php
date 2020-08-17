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

    public function login(Request $request){ 
        $webResponse = $this->account_service->loginAttemp($request); 
        $header = null;
        if($webResponse->code == "00"){
            $header = ["location"=>$request->session()->get("latest_request_url")];
        }

        return $this->json_response($webResponse,  $header);
    }
    protected function guard()
    {
        return Auth::guard('web');
    }
 
}