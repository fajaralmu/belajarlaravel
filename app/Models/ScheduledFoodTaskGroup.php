<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledFoodTaskGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scheduled_food_task_groups';
	 //join column	
public $group_member_id;
	 protected $day;
	 protected $month;
	 protected $year;
	 protected $meal_time;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 
 
	public function food_task_group_members()
    {
        return $this->belongsTo('App\Model\FoodTaskGroupMembers', 'group_member_id');
    }
  
      }