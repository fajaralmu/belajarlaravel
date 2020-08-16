<?php
namespace App\Http\Controllers\MyApp;

use App\Annotations\FormField;
use App\Http\Controllers\MyApp\BaseController;
use App\Models\Menu;
use Illuminate\Http\Request;
use ReflectionClass;  
use Doctrine\Common\Annotations\AnnotationRegistry;
use  Doctrine\Common\Annotations\AnnotationReader;

class ManagementController extends BaseController{


    public function management_page(Request $request, string $model_code){
        out("Management code: ", $model_code);
        // Deprecated and will be removed in 2.0 but currently needed
        
        AnnotationRegistry::registerLoader('class_exists');

        $reflectionClass = new ReflectionClass(Menu::class);
        $properties = $reflectionClass->getProperties();
        $annotations = array();

        foreach($properties as $property){
             
            $reader = new AnnotationReader();
            $myAnnotation = $reader->getPropertyAnnotation(
                $property,
                FormField::class
            );

            if(!is_null( $myAnnotation)){
                $myAnnotation->fieldName = $property->getName();
                array_push($annotations, $myAnnotation);
            }
           
        }
         
        return response()->json(["data"=>$annotations]);
    }
}

