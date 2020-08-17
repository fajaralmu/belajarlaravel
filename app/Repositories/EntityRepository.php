<?php 
namespace App\Repositories;

use App\Dto\Filter;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class EntityRepository {
     

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

    public function update(ReflectionClass $reflectionClass, object $entityObject){
        $tableName = $this->getTableName($reflectionClass);

        DB::table($tableName)->where([['id','=',$entityObject->id]])->update($entityObject->toArray());
        return true;
    }

    public function filter(ReflectionClass $reflectionClass, Filter $filter){
        $tableName = $this->getTableName($reflectionClass);
        
        $db = DB::table($tableName);//->get()->toArray();
        $db_count = DB::table($tableName);
        $whereClause = [];
        
       
        if( isset($filter)){
            $filter =  $filter;
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

        return [
            "resultList"=>$resultList,
            "count"=>$count
        ];
    }
    
}