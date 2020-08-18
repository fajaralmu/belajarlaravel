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
            if (is_null($formField)  )
            {
                continue;
            }

            if ($formField->foreignKey != "" && isset($propValue))
            {
                $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
                $foreignKey = $formField->foreignKey;
                $entity->$foreignKey = $propValue->id;
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

    private function validateEntityValuesAfterFilter(ReflectionClass $class, object $entity, bool $validateJoinColumn)
    {

        $props = $class->getProperties();

        foreach ($props as $prop)
        {
            $propName = $prop->name;
            $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
            if (is_null($formField))
            {
                continue;
            }

            if ($formField->foreignKey != "" && $validateJoinColumn == true)
            {
                /**
                 * join columns
                 */
                $foreignKey = $formField->foreignKey;
                $propValue = $entity->$foreignKey;

                $referenceClass = new ReflectionClass($formField->className);
                $referenceObject = $this
                    ->entityRepository
                    ->findById($referenceClass, $propValue);

                $entity->$propName = $referenceObject;
            }
            else
            {
                /**
                 * regular
                 */
                $propValue = $entity->$propName;
                if ((is_null($propValue) || $propValue == "") && $formField->defaultValue != "")
                {
                    $entity->$propName = $formField->defaultValue;
                }
            }
        }

        // foreach ($joinColumns as $prop) {
        //     $propName = $prop->name;
        //     $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
        //     $foreignKey = $formField->foreignKey;
        //     $propValue =  $entity->$foreignKey;
        //     $referenceClass = new ReflectionClass( $formField->className);
        //     $referenceObject = $this->entityRepository->findById($referenceClass, $propValue );
        //     $entity->$propName = $referenceObject;
        // }
        return $entity;
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
        $resultList = $result["resultList"];
        $validated = [];
        foreach ($resultList as $res)
        {
            array_push($validated, $this->validateEntityValuesAfterFilter($reflectionClass, $res, true));
        }

        $response = new WebResponse();
        $response->entities = $validated;
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
        // $response->entity =  $entityObject;
        return $response;
    }

    public function update(WebRequest $webRequest)
    {
        $entityCode = ($webRequest->entity);
        $entityObject = $webRequest->$entityCode;
        return $this->doUpdate($entityCode, $entityObject);
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

