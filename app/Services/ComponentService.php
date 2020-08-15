<?php

namespace App\Services;

use App\Models\Page;
use App\Repositories\PageRepository;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;

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

    public function get_pages(Request $request){
        $pages = Page::where('authorized', 0)
        ->orderBy('sequence', 'asc') 
        ->get()->toArray(); 

        return  $pages;
    }

}