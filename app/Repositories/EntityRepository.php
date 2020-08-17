<?php
namespace App\Repositories;

use App\Dto\Filter;
use App\Helpers\EntityUtil;
use App\Helpers\StringUtil;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class EntityRepository
{

    function getTableName(ReflectionClass $reflectionClass)
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

    public function findAllEntities(ReflectionClass $reflectionClass)
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

    public function update(ReflectionClass $reflectionClass, object $entityObject)
    {
        $tableName = $this->getTableName($reflectionClass);
        // DB::connection()->enableQueryLog();
         
        $arr = EntityUtil::objecttoarrayforpersist($entityObject);
       
        DB::table($tableName)->where([['id', '=', $entityObject
            ->id]])
            ->update($arr);
        return true;
    }

    public function updateWithKeys(ReflectionClass $reflectionClass, $id, array $arr)
    {
        $tableName = $this->getTableName($reflectionClass); 
       
        DB::table($tableName)->where([['id', '=', $id ]])
            ->update($arr);
        return true;
    }

    public function filter(ReflectionClass $reflectionClass, Filter $filter)
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
                $orderType = strtolower($filter->orderType) == "desc" ? "asc" : strtolower($filter->orderType);
                $db = $db->orderBy($filter->orderBy, $orderType);
            }
        }

        $resultList = $db->get()
            ->toArray();
        $count = $db_count->count();

        return ["resultList" => $resultList, "count" => $count];
    }

}

