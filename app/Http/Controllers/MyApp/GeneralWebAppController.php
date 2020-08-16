<?php
namespace App\Http\Controllers\MyApp; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralWebAppController extends BaseController{ 

    public function common_page(Request $request, string $code){
         
        out("WEB PAGE WITH CODE: ", $code);
        $page = $this->component_service->getPageAndMenus($code);

        $unauthorized =  ($page->authorized && Auth::check()==false);
        
        if(is_null($page) || $unauthorized){

            $this->clearLatestUrl($request);
            return redirect()->route("login");
        }

        return $this->appView($request, 'webpage.master-common-page', ['title'=>$page->name, 'page'=>$page]);
    }
    
 
}