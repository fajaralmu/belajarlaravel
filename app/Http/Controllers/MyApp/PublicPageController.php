<?php
namespace App\Http\Controllers\MyApp;
 
use Illuminate\Http\Request;

class PublicPageController extends BaseController
{ 
    public function about_page(Request $request){ 
        return $this->appView($request, 'webpage.about-page', ['title'=>'About Us']);
    }

}

 