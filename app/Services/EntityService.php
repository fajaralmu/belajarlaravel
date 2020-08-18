<?php
namespace App\Services;

use App\Annotations\FormField;
use App\Dto\Filter;
use App\Dto\WebRequest;
use App\Dto\WebResponse;
use App\Helpers\EntityUtil;
use App\Helpers\FileUtil;
use App\Models\BaseModel;
use App\Repositories\EntityRepository;
use Exception;
use ReflectionClass;

class EntityService
{

    private EntityRepository $entityRepository;
    private WebConfigService $webConfigService;

    public function __construct(EntityRepository $entityRepository, WebConfigService $webConfigService)
    {
        $this->entityRepository = $entityRepository;
        $this->webConfigService = $webConfigService;
    }

    private function getEntityConfig(string $entityName)
    {
        $result = $this
            ->webConfigService
            ->getConfig($entityName);
        return $result;
    }

    private function validateEntityValuesBeforePersist($entity, $originalObject = null)
    {
        $class = new ReflectionClass($entity);
        $props = $class->getProperties();
        // $joinColumns = $this->webConfigService->getJoinColumns(new ReflectionClass($entity));
        foreach ($props as $prop)
        {

            $propName = $prop->name;
            $propValue = $entity->$propName;
            $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
            
            if (is_null($formField) )
            {
                continue;
            }

            if ($formField->foreignKey != "" && isset($propValue))
            {
                $foreignKey = $formField->foreignKey; 

                if($formField->multipleSelect == true && is_array($propValue)){
                    $foreignKeys = [];
                    foreach($propValue as $propVal){
                        array_push($foreignKeys, $propVal ["id"]);
                    }
                    
                    if(sizeof( $foreignKeys) > 0){
                        $entity->$foreignKey = join("~", $foreignKeys);
                         
                    }else{
                        $entity->$foreignKey = "";
                    }
                    
                }else
                {
                    $entity->$foreignKey = $propValue->id;
                }
                unset($entity->$propName);
            }
            else if ($formField->type == "FIELD_TYPE_IMAGE")
            {
                if(isset($propValue) || trim($propValue != "")){
                    $imgName = FileUtil::writeBase64File($propValue, "IMG_" . rand(1, 999));
                    $entity->$propName = $imgName;
                }else  if(!is_null($originalObject)){
                    $entity->$propName = $originalObject->$propName;
                }

                
            }

        }
        return ($entity);
    } 

    public function findByClassNameAndId(string $className, $id){
        $referenceClass = new ReflectionClass($className);
        $referenceObject = $this
            ->entityRepository
            ->findById($referenceClass, $id);
            return  $referenceObject;
    }

    public function filter(WebRequest $webRequest)
    {
        $entityCode = ($webRequest->entity);
        
        return $this->doFilter($entityCode, $webRequest->filter);
    }

    public function doFilter(string $entityCode, Filter $filter)
    {
        $reflectionClass = $this->getEntityConfig($entityCode);
        if (is_null($reflectionClass))
        {
            return WebResponse::failed("Invalid request");
        }

        $result = $this
            ->entityRepository
            ->filter($reflectionClass, $filter); 

        $response = new WebResponse();
        $response->entities =   $result["resultList"];
        $response->totalData = $result["count"];
        $response->filter = $filter;
        return $response;
    }

    public function add(WebRequest $webRequest)
    {
        $entityCode = ($webRequest->entity);
        $entityObject = $webRequest->$entityCode;
        return $this->doAdd($entityCode, $entityObject);
    }

    public function doAdd(string $entityCode, BaseModel $entityObject)
    {
        $reflectionClass = $this->getEntityConfig($entityCode);
        if (is_null($reflectionClass))
        {
            return  WebResponse::failed("Invalid request");
        }

        $validatedObj = $this->validateEntityValuesBeforePersist($entityObject);
        unset($validatedObj->id);
        $validatedObj->save();
       
        $response = new WebResponse();
        $response->entity = json_decode(json_encode($validatedObj));
        return $response;
    }

    public function update(WebRequest $webRequest)
    {
        $entityCode = ($webRequest->entity);
        $entityObject = $webRequest->$entityCode;
        return $this->doUpdate($entityCode, $entityObject);
    }

    public function delete(WebRequest $webRequest)
    {
        $entityCode = ($webRequest->entity);
       
        $reflectionClass = $this->getEntityConfig($entityCode);
         $id = $webRequest->filter->fieldsFilter["id"];
        $deleted = $this->entityRepository->deleteById( $reflectionClass, $id);
        if($deleted){
            return new WebResponse();
        }
        throw new Exception("Error Deleting");
       
    }

    public function doUpdate(string $entityCode, BaseModel $entityObject)
    {
        $reflectionClass = $this->getEntityConfig($entityCode);

        if (is_null($reflectionClass))
        {
            return WebResponse::failed("Invalid request");
        }
        $originalObject = $this->entityRepository->findById( $reflectionClass, $entityObject->id);

        if(is_null( $originalObject)){
            return WebResponse::failed("Original Objet Does Not Exist");
        }

        $validatedObj = $this->validateEntityValuesBeforePersist($entityObject, $originalObject );
        
        $result = $this
            ->entityRepository
            ->update($reflectionClass, $validatedObj);
        // dd($queries);
        $response = new WebResponse();
        $response->message = $result;
        return $response;
    }
}

