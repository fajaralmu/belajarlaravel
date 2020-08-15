<?php 
namespace App\Repositories;

use App\User;

class UserRepository {

    public function getByUsername($username){
        return User::where(['username'=>$username])->first();
    }
}