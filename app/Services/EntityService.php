<?php
namespace App\Services;

use App\Dto\WebRequest;
use App\Dto\WebResponse;
use App\Helpers\EntityUtil;
use App\Repositories\EntityRepository;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class EntityService {

    private EntityRepository $entityRepository;
    private WebConfigService $webConfigService;

    public function __construct(EntityRepository $entityRepository, WebConfigService $webConfigService)
    {
        $this->entityRepository = $entityRepository;
        $this->webConfigService = $webConfigService;
    }

    private function getEntityConfig(string $entityName){ 
        $result = $this->webConfigService->getConfig($entityName);
        return $result;
    }
    function getTableName (ReflectionClass $reflectionClass){
        $props = $reflectionClass->getDefaultProperties();
        
        // dd(json_encode($props));
        foreach($props as$key=> $prop) {
            if( $key == "table"){
                return $prop;
            }
        }
        
        return null;
    }

    public function filter(WebRequest $webRequest){
        $reflectionClass = $this->getEntityConfig($webRequest->entity);
        if(is_null( $reflectionClass )){
            return WebResponse::failed("Invalid request");
        }
        $tableName = $this->getTableName($reflectionClass);
        
        $db = DB::table($tableName);//->get()->toArray();
        $whereClause = [];
       
        if( isset($webRequest->filter)){
            // $webRequest->filter = EntityUtil::arraytoobj(new Filter(), $webRequest->filter);
            // dd(json_encode($webRequest->filter));
            $fieldsFilter = $webRequest->filter->fieldsFilter;
            if(isset( $fieldsFilter) && sizeof( $fieldsFilter) > 0){
                foreach( $fieldsFilter as $key=>$value){
                    //like clause
                    array_push($whereClause, [$key, 'like', '%'.$value.'%']);
                }
            }
         }
        $resultList = $db->where($whereClause)->get()->toArray();
        $response = new WebResponse();
        $response ->entities = $resultList;
        $response ->filter = $webRequest->filter;
        return $response;
    }
}