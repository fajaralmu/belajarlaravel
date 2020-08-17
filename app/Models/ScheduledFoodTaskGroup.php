<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class ScheduledFoodTaskGroup extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scheduled_food_task_groups';
		
 public $group_member_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Group",optionItemName="group.name",foreignKey="group_member_id")
	 */ 
		
 public   FoodTaskGroupMember $groupMember;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $day;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $month;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $year;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST")
	 */ 
	 public $meal_time;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	protected $id;
	 public $created_date;
	 public $modified_date;
	 public $deleted;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
	 */ 
	 public $general_color;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
	 */ 
	 public $font_color;

 
	 protected $created_at, $updated_at;
 
 
	public function food_task_group_members()
    {
        return $this->belongsTo('App\Model\FoodTaskGroupMembers', 'group_member_id');
    }
  
      }