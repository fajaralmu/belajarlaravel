<?php
namespace App\Http\Controllers\MyApp;

use App\Helpers\StringUtil;
use App\Http\Controllers\MyApp\BaseController;  
use Illuminate\Http\Request;

class ManagementController extends BaseController{ 

    public function management_page(Request $request, string $model_code){
        
        out("Management code: ", $model_code); 
        $entityProperty = $this->web_config_service->getModelInfos($model_code);
        return $this->appView($request, 'webpage.entity-management-page', [
            "entityProperty"=>$entityProperty,
            "additional_style_paths"=>["entitymanagement"],
            "additional_script_paths"=>["entitymanagement"],
            "options"=>"[]",
            "entityId"=>null,
            "singleRecord"=>false,
            "title"=>StringUtil::extractCamelCase($entityProperty->entityName)
        ]);
    }
}

