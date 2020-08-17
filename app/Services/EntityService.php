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

    public function filter(WebRequest $webRequest){
        $reflectionClass = $this->getEntityConfig($webRequest->entity);
        if(is_null( $reflectionClass )){
            return WebResponse::failed("Invalid request");
        }
       
        $result = $this->entityRepository->filter($reflectionClass, $webRequest->filter);

        $response = new WebResponse(); 
        $response ->entities = $result["resultList"];
        $response ->totalData = $result["count"];
        $response ->filter = $webRequest->filter;
        return $response;
    }
}