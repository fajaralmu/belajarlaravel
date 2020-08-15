<?php
namespace App\Http\Controllers\PublicPage;

use App\Http\Controllers\Base\BaseController;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;

class PublicPageController extends BaseController
{
    public function __construct(ProfileRepository $profileRepo)
    {
        //$this->middleware('guest');
        out("-----Public Page Controller------");
        parent::__construct($profileRepo);
    }

    public function about(Request $request){
        
        return $this->appView($request, 'webpage.about-page', ['title'=>'About Us']);
    }

}

 