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
		
 protected $group_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Group",optionItemName="name",foreignKey="group_id")
	 */ 
		
 protected  Models\FoodTaskGroup $group;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Member",optionItemName="name",multipleSelect="true")
	 */ 

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $sequence;
	 protected $member_identities;

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
 
 
	public function food_task_groups()
    {
        return $this->belongsTo('App\Model\FoodTaskGroups', 'group_id');
    }
  
      }