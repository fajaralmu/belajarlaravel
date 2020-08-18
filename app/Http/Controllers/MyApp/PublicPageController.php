<?php
namespace App\Http\Controllers\MyApp;
 
use Illuminate\Http\Request;

class PublicPageController extends BaseController
{ 
    
    public function about_page(Request $request){ 
        try{
            return $this->appView($request, 'webpage.about-page', ['title'=>'About Us']);
        } catch (\Throwable $th) {
            return $this->errorPage($request,$th ); 
        }
    }
    public function mealschedule(Request $request){ 
        try{
            return $this->appView($request, 'webpage.meal-schedule-public', ['title'=>'Meal Schedule', 'additional_script_paths'=>['full-cal']]);
        } catch (\Throwable $th) {
            return $this->errorPage($request,$th ); 
        }
    }

}

 