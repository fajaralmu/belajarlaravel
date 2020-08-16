<?php 
namespace App\Repositories;
 
use App\Models\Page;

class PageRepository {
    public function getFirstByCode($page_code){
        return Page::where('code',  $page_code)  ->first(); 
    }
    
}