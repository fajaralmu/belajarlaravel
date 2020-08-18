<?php
namespace App\Http\Controllers\MyApp; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralWebAppController extends BaseController{ 

    public function common_page(Request $request, string $code){
         try{
            out("WEB PAGE WITH CODE: ", $code);
            $selectedPage = $this->component_service->getPageAndMenus($code);

            $unauthorized =  ($selectedPage->authorized && Auth::check()==false);
            
            if(is_null($selectedPage) || $unauthorized){ 
                $this->clearLatestUrl($request);
                return redirect()->route("login");
            }

            return $this->appView($request, 'webpage.master-common-page', 
                [ 'title'=>$selectedPage->name,  'page'=>$selectedPage   ]);
        } catch (\Throwable $th) {
            return $this->errorPage($request,$th ); 
        }
    }
    
 
}