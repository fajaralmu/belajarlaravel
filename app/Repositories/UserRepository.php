<?php 
namespace App\Repositories;

use App\User;

class UserRepository {


    public function saveUser(User $user){
        $user->save();
    }

    public function getByUsername(string $username){ 
        $arrayResult = User::where(['username'=>$username])->first()->toArray();
        return $arrayResult; 
    }

    public function checkUsername(string $username):bool{ 
        $arrayResult = User::where(['username'=>$username])->count();
        return $arrayResult == 0; 
    }

    public function updateApiToken($id, string $token){
        $user = User::where(['id'=>$id])->first();
        $user->api_token = $token;
        $user->save();

    }
 
    
}