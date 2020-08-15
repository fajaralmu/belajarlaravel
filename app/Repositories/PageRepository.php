<?php 
namespace App\Repositories;

use App\Models\AppProfile; 

class PageRepository {

    public function getByCode($profile_code){
        return AppProfile::where('app_code',  $profile_code)  ->first(); 
    }
}