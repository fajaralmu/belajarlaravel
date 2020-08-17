<?php
namespace App\Services;

use App\Dto\WebRequest;
use App\Dto\WebResponse;
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
        $reflectionClass = $this->getEntityConfig($webRequest->entityName);
        $tableName = $this->getTableName($reflectionClass);
        $resultList = DB::table($tableName)->get()->toArray();
        $response = new WebResponse();
        $response ->entities = $resultList;
        return $response;
    }
}