<?php
namespace App\Http\Controllers\Rest;

use App\Services\AccountService;
use Illuminate\Http\Request; 

class RestAccountController extends BaseRestController {
    protected $account_service;

    public function __construct( AccountService $account_service)
    {
        $this->account_service = $account_service;
    }

    public function login(Request $request){ 
        $webResponse = $this->account_service->loginAttemp($request); 
        return $this->json_response($webResponse);
    }

}