<?php
namespace App\Http\Controllers\MyApp; 
use Illuminate\Http\Request; 

class AdminController extends BaseController{ 

    public function home_page(Request $request){
         
        return $this->appView($request, 'webpage.home-page', ['title'=>'Home']);
    }

    public function menu_order(Request $request){
        
        return $this->appView($request, 'webpage.sequenceordering', [
            'title'=>'Menu Order',
            "displayField"=>"name",
            "entityName"=>"page",
            "idField"=>"id",
            "additional_style_paths" => ["sequenceordering" ]
            ]);
    }
    
 
}