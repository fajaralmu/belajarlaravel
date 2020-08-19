<?php 
namespace App\Repositories;

use App\User;

class UserRepository {


    public function getByUsername($username){ 
        $arrayResult = User::where(['username'=>$username])->first()->toArray();
        return $arrayResult; 
    }

    public function updateApiToken($id, string $token){
        $user = User::where(['id'=>$id])->first();
        $user->api_token = $token;
        $user->save();

    }
 
    
}