<?php 
namespace App\Repositories;

use App\Models\FoodTaskGroupMember; 

class MealTaskGroupMemberRepository {
    public function getAll( ){
        return FoodTaskGroupMember::where('id','!=', null) ->get();
    }
    
}