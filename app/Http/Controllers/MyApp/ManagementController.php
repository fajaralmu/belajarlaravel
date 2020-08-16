<?php
namespace App\Http\Controllers\MyApp;

use App\Http\Controllers\MyApp\BaseController;  
use Illuminate\Http\Request;

class ManagementController extends BaseController{

   

    public function management_page(Request $request, string $model_code){
       
        out("Management code: ", $model_code); 
        return response()->json(["data"=>$this->web_config_service->getModelInfos(($model_code))]);
    }
}

