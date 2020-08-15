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
	public $day;
	public $month;
	public $year;
	public $meal_time;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
 
	public function food_task_group_members()
    {
        return $this->hasOne('App\Model\FoodTaskGroupMembers');
    }
  
      }