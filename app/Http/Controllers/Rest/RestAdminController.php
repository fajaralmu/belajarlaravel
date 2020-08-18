<?php
namespace App\Http\Controllers\Rest;

use App\Services\AccountService;
use App\Services\ComponentService;
use App\Services\WebConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestAdminController extends BaseRestController {
    protected ComponentService $component_service;
  
    public function __construct( ComponentService $component_service)
    {
        $this->component_service = $component_service; 
        parent::__construct();
    }

    public function update_order(Request $request, string $code){ 
        try{
            $webRequest = $this->getWebRequest($request); 
            $response = $this->component_service->saveEntitySequence($webRequest, $code);
            return $this->json_response($response); 
            
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
    }
    public function create_meal_schedule(Request $request, int $beginningIndex){ 
        try{
            $webRequest = $this->getWebRequest($request);  
            $response = $this->component_service->createMealSchedule($webRequest, $beginningIndex, $request);
            return $this->json_response($response); 
            
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
 
}