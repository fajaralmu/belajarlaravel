<?php
namespace App\Repositories;

use App\Annotations\FormField;
use App\Dto\Filter;
use App\Helpers\EntityUtil;
use App\Helpers\StringUtil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use ReflectionClass;
use Throwable;

class EntityRepositoryImpl implements EntityRepository
{

    public function getTableName(ReflectionClass $reflectionClass):string
    {
        $props = $reflectionClass->getDefaultProperties();

        // dd(json_encode($props));
        foreach ($props as $key => $prop)
        {
            if ($key == "table")
            {
                return $prop;
            }
        }

        return null;
    }

    public function findAllEntities(ReflectionClass $reflectionClass):array
    {
        $tableName = $this->getTableName($reflectionClass);

        $db = DB::table($tableName)->get();

        return $db->toArray();
    }

    public function findById(ReflectionClass $reflectionClass, $id)
    {
        $tableName = $this->getTableName($reflectionClass);

        $db = DB::table($tableName)->where([['id', '=', $id]]); 
        $result = $db->get();
        
        if (sizeof($result) > 0)
        {
            return $result[0];
        }
        return null;
    }

    public function add(ReflectionClass $reflectionClass, object $entityObject):object{
        unset($entityObject->id);

        $entityObject->created_at = now();
        $entityObject->save();

        return $entityObject;
    }
    public function update(ReflectionClass $reflectionClass, object $entityObject):object
    {
        $tableName = $this->getTableName($reflectionClass); 
         
        $arr = EntityUtil::objecttoarrayforpersist($entityObject);
        $arr['updated_at'] = now();

        // try{ 

        $db = DB::table($tableName)->where([['id', '=', $entityObject->id]]); 
        $db->update($arr);
        
        $result = $this->findById($reflectionClass, $entityObject->id);

        return $result;
        // }catch(Throwable $th){
        //     Log::error('Error update entity: '.$th->getMessage());
        //     return [];
        // }
    }

    public function updateWithKeys(ReflectionClass $reflectionClass, $id, array $arr):bool
    {
        $tableName = $this->getTableName($reflectionClass); 
       try{
            DB::table($tableName)->where([['id', '=', $id ]])
                ->update($arr);
            return true;
        }catch(Throwable $th){
            Log::error('Error update entity: '.$th->getMessage());
            return false;
        }
    }

    public function findWithKeys(ReflectionClass $reflectionClass,   array $filter):array
    {
        try{
            $tableName = $this->getTableName($reflectionClass);  
            $result = DB::table($tableName)->where($filter) ->get();
            return $result->toArray();
        }catch(Throwable $th){
            return [];
        }
    }

    public function deleteById(ReflectionClass $reflectionClass,     $id):bool
    {
        try{
            $tableName = $this->getTableName($reflectionClass);  
            DB::table($tableName)->delete($id);
            return true;
        }catch(Throwable $th){
            out("ERROR DELETING: ".$th->getMessage());
            return false;
        }
    }

    public function filter(ReflectionClass $reflectionClass, Filter $filter):array
    {
        $tableName = $this->getTableName($reflectionClass);

        $db = DB::table($tableName); //->get()->toArray();
        $db_count = DB::table($tableName);
        $whereClause = [];

        if (isset($filter))
        {
            $filter = $filter;
            $fieldsFilter = $filter->fieldsFilter;
            $exactSearch = $filter->exacts == true;

            if (isset($fieldsFilter) && sizeof($fieldsFilter) > 0)
            {
                foreach ($fieldsFilter as $key => $value)
                {
                    $operator = null;
                    $partialExact = false;

                    if (StringUtil::strContains($key, "[EXACTS]"))
                    {
                        $partialExact = true;
                        $substringStart = strlen($key) - strlen("[EXACTS]");
                        $key = substr($key, 0, $substringStart);
                    }

                    if ($exactSearch || $partialExact)
                    {
                        $operator = "=";
                    }
                    else
                    {
                        $operator = "like";
                        $value = '%' . $value . '%';

                    }
                    array_push($whereClause, [$key, $operator, $value]);
                }

                $db = $db->where($whereClause);
                $db_count = $db_count->where($whereClause);
            }
            if (isset($filter->limit) && $filter->limit > 0)
            {
                $offset = $filter->page * $filter->limit;
                $db = $db->offset($offset)->limit($filter->limit);
            }
            if (isset($filter->orderBy) && trim($filter->orderBy) != "")
            {
                $orderType = "asc";
                if(strtolower($filter->orderType) != "asc"){
                    $orderType = "desc";
                }
                $db = $db->orderBy($filter->orderBy, $orderType);
            }
        }

        $resultList = $db->get()->toArray();
        $count = $db_count->count();

        $validated = [];
        foreach ($resultList as $res)
        {
            array_push($validated, $this->validateEntityValuesAfterFilter($reflectionClass, $res, true));
        }

        return ["resultList" => $validated, "count" => $count];
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
            if(!property_exists($entity, $propName)){
                // dd($entity, $propName,"Does not exist");
                $entity->{$propName} = [];
            }
            if ($formField->foreignKey != "" && $validateJoinColumn == true)
            {
                /**
                 * join columns
                 */
                $foreignKey = $formField->foreignKey;
                $propValue = $entity->$foreignKey;
                if(!isset($propValue)){
                    continue;
                }
                
                $className = $formField->className;
                if($formField->multipleSelect == true){
                    $rawForeignKeys = explode("~", $propValue);
                    $values = [];
                    foreach($rawForeignKeys as $fk){ 
                        $obj = $this->findByClassNameAndId($className, $fk);
                        //no recursive?
                        array_push( $values, $obj);
                    }
                    $entity->$propName = $values;
                }else{
                    
                    $referenceObject = $this->findByClassNameAndId($className, $propValue);   
                  
                    $validated  = [];
                    try{
                        //recursive
                        $validated = $this->validateEntityValuesAfterFilter(new ReflectionClass($className), $referenceObject, true);
                    }catch(Throwable $th){
                        $validated = $referenceObject;
                    }
                    $entity->$propName = $validated;
                }
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

       
        return $entity;
    }


    public function findByClassNameAndId(string $className, $id):object{
        $referenceClass = new ReflectionClass($className);
        $referenceObject = $this->findById($referenceClass, $id);
            return  $referenceObject;
    }
}

