<?php
namespace App\Http\Controllers\Rest;

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
        $webRequest = $this->getWebRequest($request);
        //dd($webRequest);
        $response = $this->entity_service->filter($webRequest);
        return $this->json_response($response);
    }

    
}