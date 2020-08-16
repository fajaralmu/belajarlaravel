<?php
namespace App\Http\Controllers\MyApp; 
use Illuminate\Http\Request; 

class GeneralWebAppController extends BaseController{ 

    public function common_page(Request $request, string $code){
         
        out("WEB PAGE WITH CODE: ", $code);
        $page = $this->component_service->getPageAndMenus($code);
        return $this->appView($request, 'webpage.master-common-page', ['title'=>$page->name, 'page'=>$page]);
    }
    
 
}