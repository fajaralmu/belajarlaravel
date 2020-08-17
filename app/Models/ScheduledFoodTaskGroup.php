<?php

namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column; 

class ScheduledFoodTaskGroup extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scheduled_food_task_groups';

		 /**
	 * @Column() 
 */  		
 protected $group_member_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Group",optionItemName="group.name",className="App\Models\FoodTaskGroupMember",foreignKey="group_member_id")
	 */ 
		
 protected   FoodTaskGroupMember $groupMember;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $day;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $month;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $year;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST")
	  
	 
	 * @Column() 
	 */
	 protected $meal_time;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $id;
	
	/*
	 
	 * @Column() 
	 */
	 protected $created_date;
	
	/*
	 
	 * @Column() 
	 */
	 protected $modified_date;
	
	/*
	 
	 * @Column() 
	 */
	 protected $deleted;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
	  
	 
	 * @Column() 
	 */
	 protected $general_color;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
	  
	 
	 * @Column() 
	 */
	 protected $font_color;

 
	/**
	 * @Column() 
	*/
	 protected $created_at; 
	/**
	 * @Column() 
	*/ 
	protected $updated_at;
 
 
	public function food_task_group_members()
    {
        return $this->belongsTo('App\Model\FoodTaskGroupMembers', 'group_member_id');
    }
  
      }