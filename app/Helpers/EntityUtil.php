<?php 

namespace App\Helpers;

use App\Annotations\FormField;

use Doctrine\Common\Annotations\AnnotationRegistry;
use  Doctrine\Common\Annotations\AnnotationReader;
use ReflectionProperty;
use ReflectionClass;

class EntityUtil {
    

    public static function getAnnotations(ReflectionClass  $reflectionClass ){
        AnnotationRegistry::registerLoader('class_exists');
 
        $properties = $reflectionClass->getProperties();
        $annotations = array();

        foreach($properties as $property){
              
            $myAnnotation = EntityUtil::getPropertyAnnotation($property, FormField::class );

            if(!is_null( $myAnnotation)){
                $myAnnotation->fieldName = $property->getName();
                array_push($annotations, $myAnnotation);
            }
           
        }

        return $annotations;
    }

    public static function getPropertyAnnotation(ReflectionProperty $property, $annotationClass){
        $reader = new AnnotationReader();
        $myAnnotation = $reader->getPropertyAnnotation(
            $property,
            $annotationClass
        );
        return $myAnnotation;
    }

}