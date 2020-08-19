<?php
namespace App\Repositories;
 
use App\Dto\Filter; 
use ReflectionClass; 

interface EntityRepository
{

    public function findAllEntities(ReflectionClass $reflectionClass):array;
    public function findById(ReflectionClass $reflectionClass, $id);
    public function update(ReflectionClass $reflectionClass, object $entityObject):object;
    public function add(ReflectionClass $reflectionClass, object $entityObject):object;
    public function updateWithKeys(ReflectionClass $reflectionClass, $id, array $arr):bool;
    public function findWithKeys(ReflectionClass $reflectionClass,   array $filter):array;
    public function deleteById(ReflectionClass $reflectionClass,     $id):bool;
    public function filter(ReflectionClass $reflectionClass, Filter $filter):array;
    public function findByClassNameAndId(string $className, $id):object;
}

