<?php
namespace App\Repositories;

use App\Annotations\FormField;
use App\Dto\Filter;
use App\Helpers\EntityUtil;
use App\Helpers\StringUtil;
use Illuminate\Database\Query\Builder;
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

    private function isDateKey(string $key){
        return sizeof(explode("-", $key)) == 2 && StringUtil::ends_with_some($key, "-day","-month", "-year");
    }

    public function filter(ReflectionClass $reflectionClass, Filter $filter):array
    {
        $tableName = $this->getTableName($reflectionClass);
        DB::enableQueryLog();
        $db = DB::table($tableName); 
        $db_count = DB::table($tableName);
        $whereClause = [];
        $joinKeys = [];

        if (isset($filter))
        { 
            $fieldsFilter = $filter->fieldsFilter;
            $exactSearch = $filter->exacts == true;
            $whereRaws = [];

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

                    }else if($this->isDateKey($key)){

                        $param = explode("-", $key);
                        $key = $param[1]."(`".  $param[0]."`)";
                          $whereRaws  [$key]=  $value;
                        continue;

                    }else if(StringUtil::strContains($key, '.')){
                        $joinKeys[$key] = $value;
                        continue;
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
               
                ///////////PROCESS JOIN COLS///////////
                $db = $this->processJoinCols($reflectionClass, $db ,$joinKeys);

                //////////RAW QUERIES/////////  
                $db = $this->checkRawQuery($db, $whereRaws);
                $db_count = $this->checkRawQuery($db_count, $whereRaws);
               
            }
            $db = $this->checkOffsetLimit($db, $filter);
            $db = $this->checkOrdering($db, $filter);
        }
      
        $resultList = $db->get()->toArray();
        $count = $db_count->count();
        // dd(  DB::getQueryLog());
        $validated = [];
        foreach ($resultList as $res)
        {
            array_push($validated, $this->validateEntityValuesAfterFilter($reflectionClass, $res, true));
        }

        return ["resultList" => $validated, "count" => $count];
    }

    private function getFormField(ReflectionClass $class, string $fieldName):FormField{
        $prop = $class->getProperty($fieldName);
        $formField = EntityUtil::getFormField($prop);
        return $formField;
    }

    private function getTableNameByClassName(string $className):string { 
            $referenceClass = new ReflectionClass($className);
            $table = $this->getTableName($referenceClass);
            return $table;
    }

    //TODO: support exact search
    private function processJoinCols(ReflectionClass $reflectionClass, Builder $db, array $joinKeys):Builder {
        $thisTable = $this->getTableName($reflectionClass);
        if(sizeof($joinKeys)>0){
            foreach ($joinKeys as $key => $value) {
                try {
                    $rawKey = explode(".", $key); 
                    $formField = $this->getFormField($reflectionClass, $rawKey[0]);
                    if(!isset($formField)){
                        continue;
                    } 

                    $className = $formField->className;
                    $foreignKey = $formField->foreignKey; 
                    $refTable = $this->getTableNameByClassName($className);
                    
                    $db = $db->join($refTable,  $thisTable.'.'.$foreignKey, '=', $refTable.'.id');
                    $db  = $db->whereRaw($refTable.'.'.$rawKey[1].' like ?', ["%".$value."%"]);

                } catch (\Throwable $th) {
                   continue;
                } 
            }
        }

        return $db;
    }

    private function checkRawQuery(Builder $db, array $whereRaws):Builder{
        if(sizeof($whereRaws)>0){
            foreach ($whereRaws as $key => $value) { 
                $db = $db->whereRaw( $key ."=?", [$value]); 
            }
        }
        return  $db;
    }

    private function checkOffsetLimit(Builder $db, Filter $filter):Builder{
        if (isset($filter->limit) && $filter->limit > 0)
            {
                $offset = $filter->page * $filter->limit;
                $db = $db->offset($offset)->limit($filter->limit);
            }
            return $db;
    }

    private function checkOrdering(Builder $db, Filter $filter):Builder{
        if (isset($filter->orderBy) && trim($filter->orderBy) != "")
            {
                $orderType = "asc";
                if(strtolower($filter->orderType) != "asc"){
                    $orderType = "desc";
                }
                $db = $db->orderBy($filter->orderBy, $orderType);
            }
            return $db;
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

