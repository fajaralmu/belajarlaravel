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
		
 protected $group_member_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Group",optionItemName="group.name",foreignKey="group_member_id")
	 */ 
		
 protected  Models\FoodTaskGroupMember $groupMember;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $day;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $month;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $year;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST")
	 */ 
	 protected $meal_time;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
	 */ 
	 protected $general_color;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
	 */ 
	 protected $font_color;

 
	public $created_at, $updated_at;
 
 
	public function food_task_group_members()
    {
        return $this->belongsTo('App\Model\FoodTaskGroupMembers', 'group_member_id');
    }
  
      }