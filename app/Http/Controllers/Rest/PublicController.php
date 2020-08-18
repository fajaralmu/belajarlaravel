<?php
namespace App\Http\Controllers\Rest;

use App\Dto\Filter;
use App\Services\EntityService;
use Illuminate\Http\Request; 

class PublicController extends BaseRestController {

    protected $entity_service;

    public function __construct( EntityService $entity_service)
    {
        $this->entity_service = $entity_service;
        parent::__construct();
    }
    public function pageCode(Request $request){ 

        $msg = 'UNDER-CONSTRUCTION';
        return $this->webResponse("00", $msg);
    }
    public function mealschedule(Request $request){ 

         try{   
            
            $filter = new Filter();
            $filter->fieldsFilter = [
                "month"=>$request->get("month"),"year"=>$request->get("year")
            ];
             
            $response = $this->entity_service->doFilter("scheduledfoodtaskgroup", $filter);
            return $this->json_response($response);
            
        } catch (\Throwable $th) {
            return $this->webResponse("01", $th->getMessage()); 
        }
    }

}