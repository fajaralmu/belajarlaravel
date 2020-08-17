<?php

namespace App\Services;

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

class WebConfigService {

    private $entityConfig = array();

    public function __construct()
    {
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
        $entityProperty = EntityUtil::createEntityProperty($refectionClass);
        
        return  $entityProperty;
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