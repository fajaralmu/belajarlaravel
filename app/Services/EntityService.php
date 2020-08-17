<?php
namespace App\Services;

use App\Annotations\FormField;
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

    private function validateEntityValues(&$entity){

        $joinColumns = $this->webConfigService->getJoinColumns(new ReflectionClass($entity));
        foreach ($joinColumns as $prop) {
            $propName = $prop->name;
            $propValue =  $entity->$propName;
            if(!isset($propValue)){
                continue;
            }
            $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
            $foreignKey = $formField->foreignKey;
            $entity->$foreignKey =  $propValue->id;
            // unset($entity, $prop->name);
        }
    }

    private function validateEntityValuesAfterFilter(ReflectionClass $class, $entity){
         
        $joinColumns = $this->webConfigService->getJoinColumns($class);
        
        
        foreach ($joinColumns as $prop) {
            $propName = $prop->name; 
            $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
            $foreignKey = $formField->foreignKey; 
            $propValue =  $entity->$foreignKey; 
            
            $referenceClass = new ReflectionClass( $formField->className); 
            $res = $this->entityRepository->findById($referenceClass, $propValue ); 
            // $entity->$foreignKey =  $propValue ['id'];
            $entity->$propName =  $this->arraytoobject($res, $formField->className);
            // unset($entity, $prop->name);
        }
          
        return $entity;
       
    }

    public function arraytoobject(  $arr, $className){
       
        $obj = new $className();
        foreach($arr as $key => $value){
            $obj->$key = $value;
        }
        
        return $obj;
    }

    public function filter(WebRequest $webRequest){
        $reflectionClass = $this->getEntityConfig($webRequest->entity);
        if(is_null( $reflectionClass )){
            return WebResponse::failed("Invalid request");
        }
       
        $result = $this->entityRepository->filter($reflectionClass, $webRequest->filter);
        $resultList =  $result["resultList"];
        $validated = [];
        foreach ($resultList as $res) {
           array_push($validated, $this->validateEntityValuesAfterFilter( $reflectionClass, $res));
        }
        
        $response = new WebResponse(); 
        $response->entities =  $validated;
        $response->totalData = $result["count"];
        $response->filter = $webRequest->filter;
        return $response;
    }

    public function add(WebRequest $webRequest){
        $reflectionClass = $this->getEntityConfig($webRequest->entity);
        if(is_null( $reflectionClass )){
            return WebResponse::failed("Invalid request");
        }

        $fieldName = ($webRequest->entity);
        $entityObject = $webRequest->$fieldName;
        
        unset($entityObject->id);  
        $entityObject->save();

        $response = new WebResponse(); 
        // $response->entity =  $entityObject;
        return $response;
    }

    public function update(WebRequest $webRequest){
        $reflectionClass = $this->getEntityConfig($webRequest->entity);
       
        if(is_null($reflectionClass )){
            return WebResponse::failed("Invalid request");
        }
        $fieldName = ($webRequest->entity);
        $entityObject = $webRequest->$fieldName; 
        $this->validateEntityValues($entityObject);
        $result = $this->entityRepository->update($reflectionClass,  $entityObject);
        $response = new WebResponse(); 
         $response->message =  $result;
        return $response;
    }
}