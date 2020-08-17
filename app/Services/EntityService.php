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
        $db_count = DB::table($tableName);
        $whereClause = [];
        
       
        if(property_exists($webRequest, "filter") && isset($webRequest->filter)){
            $filter =  $webRequest->filter;
            $fieldsFilter = $filter->fieldsFilter;
            $exactSearch = $filter->exacts;
            
            if(isset( $fieldsFilter) && sizeof( $fieldsFilter) > 0){
                foreach( $fieldsFilter as $key=>$value){
                    $operator = null;
                     
                    if($exactSearch){
                        $operator = "like";
                        $value = '%'.$value.'%';
                    }else{
                        $operator = "=";
                    }
                    array_push($whereClause, [$key, $operator, $value]);
                }

               $db = $db->where($whereClause);
               $db_count = $db_count->where($whereClause);
            } 
            if(isset($filter->limit) && $filter->limit>0){
                $offset = $filter->page * $filter->limit;
                $db = $db->offset($offset)->limit($filter->limit);
            }
            if(isset($filter->orderBy) && trim($filter->orderBy)!=""){
                $orderType = strtolower($filter->orderType) == "desc"?"asc":strtolower($filter->orderType);
                $db = $db->orderBy($filter->orderBy, $orderType);
            }
         }
         
        $resultList = $db->get()->toArray();
        $count = $db_count->count();

        $response = new WebResponse(); 
        $response ->entities = $resultList;
        $response ->totalData =  $count;
        $response ->filter = $webRequest->filter;
        return $response;
    }
}