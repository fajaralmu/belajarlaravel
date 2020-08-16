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

//
use App\Annotations\FormField; 
use Doctrine\Common\Annotations\AnnotationRegistry;
use  Doctrine\Common\Annotations\AnnotationReader;
use ReflectionProperty;

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

    private function getAnnotations(ReflectionClass  $reflectionClass ){
        AnnotationRegistry::registerLoader('class_exists');
 
        $properties = $reflectionClass->getProperties();
        $annotations = array();

        foreach($properties as $property){
              
            $myAnnotation = $this->getProperyAnnotation($property, FormField::class );

            if(!is_null( $myAnnotation)){
                $myAnnotation->fieldName = $property->getName();
                array_push($annotations, $myAnnotation);
            }
           
        }

        return $annotations;
    }

    public function getProperyAnnotation(ReflectionProperty $property, $annotationClass){
        $reader = new AnnotationReader();
        $myAnnotation = $reader->getPropertyAnnotation(
            $property,
            $annotationClass
        );
        return $myAnnotation;
    }

    public function getModelInfos(string $model_code){
       
        if(!array_has( $this->entityConfig, $model_code)){
            return [];
        }
        $refectionClass = $this->entityConfig[$model_code]; 
        return $this->getAnnotations($refectionClass);

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