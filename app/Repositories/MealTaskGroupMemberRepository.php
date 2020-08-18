<?php 
namespace App\Repositories;

use App\Models\FoodTaskGroupMember; 

class MealTaskGroupMemberRepository {
    /**
     * OrderBy sequence asc
     */
    public function getAll( ){
        return FoodTaskGroupMember::where('id','!=', null)->orderBy("sequence", "asc") ->get();
    }
    
}