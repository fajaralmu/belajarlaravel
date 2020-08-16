<?php

namespace App\Services;

use App\Models\Page;
use App\Repositories\PageRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComponentService {

    protected ProfileRepository $profile_repository;
    protected PageRepository $page_repository;

    public function __construct(ProfileRepository $profile_repository, PageRepository $page_repository )
    {
        $this->profile_repository = $profile_repository;
        $this->page_repository =  $page_repository;
    }

    public function getProfile(){
        $profile_code = config("app.general.APP_CODE");
        return $this->profile_repository->getOneBy("app_code", $profile_code);
    }

    public function getPages(Request $request){
        out("USER: ", $request->user());
        $pages = array();
        if(Auth::check()){
            $pages = Page::orderBy('sequence', 'asc')  ->get()->toArray(); 

        }else{
            $pages = Page::where('authorized', 0) ->orderBy('sequence', 'asc')  ->get()->toArray(); 

        }
       
        return  $pages;
    }

    public function getPageAndMenus(string $page_code){
        $page = $this->page_repository->getFirstByCode($page_code); 
         
        return $page;
    }

}