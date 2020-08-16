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
     * override parent method
     */
    protected function postConstruct()
    {
        $this->putConfig(Menu::class, User::class, UserRole::class, Page::class,
        AppProfile::class, Member::class, MemberFee::class, FoodTaskGroup::class,
        FoodTaskGroupMember::class, RegisteredRequest::class, ScheduledFoodTaskGroup::class);

    } 
    
    public function getModelInfos(string $model_code){
       
        if(!array_has( $this->entityConfig, $model_code)){
            return [];
        }
        $refectionClass = $this->entityConfig[$model_code]; 
        return EntityUtil::createEntityProperty($refectionClass);

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