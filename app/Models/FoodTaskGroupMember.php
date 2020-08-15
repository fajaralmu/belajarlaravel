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
	 protected $sequence;
	 protected $member_identities;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 
 
	public function food_task_groups()
    {
        return $this->belongsTo('App\Model\FoodTaskGroups', 'group_id');
    }
  
      }