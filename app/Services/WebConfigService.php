<?php

namespace App\Services;

use App\Annotations\FormField;
use App\Models\FoodTaskGroup;
use App\Models\FoodTaskGroupMember;
use App\Models\Member;
use App\Models\MemberFee;
use App\Models\Menu;
use App\Models\Page;
use App\Models\UserRole;
use App\Models\AppProfile;
use App\Models\RegisteredRequest;
use App\Models\ScheduledFoodTaskGroup;
use App\User;
use ReflectionClass;  
use App\Helpers\EntityUtil;
use App\Repositories\EntityRepository;

class WebConfigService {

    private $entityConfig = array();
    private EntityRepository $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
        $this->postConstruct();
    } 

    /**
     * @param key
     * @return ReflectionClass
     */
    public function getConfig(string $key){
        if(array_has( $this->entityConfig, $key)){
            return $this->entityConfig[$key];
        } 
        return null;
    }
    /**
     * override parent method
     */
    protected function postConstruct()
    {
        $this->putConfig(Menu::class, User::class, UserRole::class, Page::class,
        AppProfile::class, Member::class, MemberFee::class, FoodTaskGroup::class,
        FoodTaskGroupMember::class, RegisteredRequest::class, ScheduledFoodTaskGroup::class);

    } 
    
    public function getModelInfos(string $model_code){
        // dd( $this->entityConfig);
        if(!array_has( $this->entityConfig, $model_code)){
            return null;
        }
        $refectionClass = $this->entityConfig[$model_code]; 
        $additionalMap = $this->getAdditionalMap($refectionClass);
        $entityProperty = EntityUtil::createEntityProperty($refectionClass, $additionalMap);
        
        return  $entityProperty;
    }

    private function getAdditionalMap(ReflectionClass $reflectionClass) {
        $joinColumnProps = $this->getJoinColumns($reflectionClass);
        $map = [];
        foreach ($joinColumnProps as $prop) {
            $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
            
            $propName = EntityUtil::getPropName($prop);
           
            $isCustomObject = substr($propName,  0, 4 ) === "App\\";
            if($isCustomObject){
                $propName = str_replace("Models\\Models","Models",$propName);
                $referenceClass = new ReflectionClass($propName);
                $map[$prop->name] = $this->entityRepository->findAllEntities($referenceClass);
            }
          
        }
        // dd($map);
        return $map;
    }

    public function getJoinColumns(ReflectionClass $reflectionClass) {
        $props = $reflectionClass->getProperties();
        $joinColumProps = [];

        foreach($props as $prop){
            $formField = EntityUtil::getPropertyAnnotation($prop, FormField::class);
            if(is_null($formField)){
                continue;
            }
            if( $formField->foreignKey != ""){ 
                array_push($joinColumProps, $prop);
            }
        }


        return $joinColumProps;
    }
    
    private function putConfig(...$classes){
        foreach ($classes as $class) {
            if(!is_null($class)) {
                $reflectionClass = new ReflectionClass($class);
                $key = strtolower($reflectionClass->getShortName());
                $this->entityConfig[$key] =  $reflectionClass;
            } 

        }
        // dd( $this->entityConfig);
    }
}