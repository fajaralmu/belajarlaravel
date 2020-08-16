<?php 
namespace App\Repositories;

use App\Models\AppProfile; 

class ProfileRepository {

    public function getOneBy($key, $value){
        return AppProfile::where($key,  $value)->first(); 
    }

    public function getByCode($profile_code){
        return AppProfile::where('app_code',  $profile_code)  ->first(); 
    }
}