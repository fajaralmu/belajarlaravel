<?php 

namespace App\Helpers;

use App\Annotations\FormField;

use Doctrine\Common\Annotations\AnnotationRegistry;
use  Doctrine\Common\Annotations\AnnotationReader;
use ReflectionProperty;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionType;

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

    public static function createEntityProperty(ReflectionClass $clazz, array $additionalObjectList = [])  {
		if ($clazz == null ){//|| getClassAnnotation($clazz, Dto.class) == null) {
			return null;
		}

		// Dto dto = (Dto) getClassAnnotation($clazz, Dto.class);
		$ignoreBaseField = false;// dto.ignoreBaseField();
		$isQuestionare = false;// dto.quistionare();

        $entityProperty = new EntityProperty();
        $entityProperty->ignoreBaseField = $ignoreBaseField;
        $entityProperty->entityName = strtolower($clazz->getShortName());
        $entityProperty->isQuestionare = $isQuestionare;
	 
		// try {

			$fieldList = $clazz->getProperties();

			if ($isQuestionare) {

                //FIXME
				// Map<String, List<Field>> groupedFields = sortListByQuestionareSection(fieldList);
				// fieldList = CollectionUtil.mapOfListToList(groupedFields);
				// Set<String> groupKeys = groupedFields.keySet();
				// String[] keyNames = CollectionUtil.toArrayOfString(groupKeys.toArray());

				// $entityProperty->setGroupNames(keyNames);
			}
			$entityElements = [];
			$fieldNames =[];
			$fieldToShowDetail = "";

			foreach ($fieldList as $field) {

				$entityElement = EntityElement::construct2($field, $entityProperty, $additionalObjectList);

				if (null == $entityElement || false == $entityElement->build()) {
					continue;
				}
				if ($entityElement->detailField ) {
					$fieldToShowDetail = $entityElement->id;
				}

				array_push($fieldNames, $entityElement->id);
				array_push($entityElements, $entityElement);
			}

            // $entityProperty->alias(dto.value().isEmpty() ? StringUtil::extractCamelCase($clazz.getSimpleName()) : dto.value());
            $entityProperty->alias= StringUtil::extractCamelCase($clazz->getShortName());
			$entityProperty->editable=true;//(dto.editable());
			$entityProperty->setElementJsonList();
			$entityProperty->elements=($entityElements);
			$entityProperty->detailFieldName=($fieldToShowDetail);
			$entityProperty->dateElementsJson=(json_encode($entityProperty->dateElements));
			$entityProperty->fieldNames=(json_encode($fieldNames));//, JSON_UNESCAPED_SLASHES ));
            $entityProperty->fieldNameList=($fieldNames);
            // echo  ($entityProperty->fieldNames);
            // out($entityProperty->fieldNames);
            // dd($entityProperty->fieldNames);
			$entityProperty->formInputColumn=2;//(dto.formInputColumn().value);
			$entityProperty->determineIdField();

			out("============ENTITY PROPERTY: {} ", $entityProperty);

			return $entityProperty;
		// } catch (Exception e) {
		// 	e.printStackTrace();
		// 	throw e;
		// } 
    }
    
    public static function arraytoobj($obj, $arr){
		$reflectionClass = new ReflectionClass($obj); 
        foreach ($arr as $key => $value) {
			$prop = $reflectionClass->getProperty($key);
			if(!is_null($prop)){
			 
				$propType = $prop->getType();
				$propName =  $propType->getName(); //ReflectionNamedType::getName()
				if(substr(  $propName,  0, 4 ) === "App\\"){
					out("==========>".$propName);
					$obj->$key = EntityUtil::arraytoobj(new $propName(), $value);
				}else{
					$obj->$key = $value;
				}
			}
           
		} 
		
        return $obj;
    }

}