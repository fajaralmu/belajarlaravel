<?php
namespace App\Http\Controllers\MyApp; 
use Illuminate\Http\Request; 

class AdminController extends BaseController{ 

    public function home_page(Request $request){
        try{   
            return $this->appView($request, 'webpage.home-page', ['title'=>'Home']);
        } catch (\Throwable $th) {
            return $this->errorPage($request,$th ); 
        }
    }

    public function menu_order(Request $request){
        try{
            return $this->appView($request, 'webpage.sequenceordering', [
                'title'=>'Menu Order',
                "displayField"=>"name",
                "entityName"=>"page",
                "idField"=>"id",
                "additional_style_paths" => ["sequenceordering" ]
                ]);

        } catch (\Throwable $th) {
            return $this->errorPage($request,$th ); 
        }
    }
    
 
}