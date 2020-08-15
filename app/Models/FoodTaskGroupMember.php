<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodTaskGroupMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'food_task_group_members';
	 //join column	
public $group_id;
	public $sequence;
	public $member_identities;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
 
	public function food_task_groups()
    {
        return $this->hasOne('App\Model\FoodTaskGroups');
    }
  
      }