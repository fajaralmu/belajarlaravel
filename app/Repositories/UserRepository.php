<?php 
namespace App\Repositories;

use App\User;

class UserRepository {


    public function getByUsername($username){ 
        $arrayResult = User::where(['username'=>$username])->first()->toArray();
        return $arrayResult; 
    }
 
    
}