<?php
namespace App\Http\Controllers\Rest;

use App\Dto\WebResponse;
use App\Services\EntityService;
use Illuminate\Http\Request;

class RestEntityController extends BaseRestController {
    
    protected $entity_service;

    public function __construct( EntityService $entity_service)
    {
        $this->entity_service = $entity_service;
        parent::__construct();
    }

    public function get_entity(Request $request){
        try {
            $webRequest = $this->getWebRequest($request);
        
            $response = $this->entity_service->filter($webRequest);
            return $this->json_response($response); 
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
       
    }

    public function add_entity(Request $request){
     try{   $webRequest = $this->getWebRequest($request);
         
        $response = $this->entity_service->add($webRequest);
        return $this->json_response($response);
    } catch (\Throwable $th) {
        return $this->webResponse("01", $th->getMessage()); 
    }
    }

    public function update_entity(Request $request){
         try{   $webRequest = $this->getWebRequest($request);
         
        $response = $this->entity_service->update($webRequest);
        return $this->json_response($response);
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
    }

    
}