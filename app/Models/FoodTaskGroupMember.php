<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class FoodTaskGroupMember extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'food_task_group_members';
		
 public $group_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Group",optionItemName="name",foreignKey="group_id")
	 */ 
		
 public   FoodTaskGroup $group;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Member",optionItemName="name",multipleSelect="true")
	 */ 

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $sequence;
	 public $member_identities;

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
 
 
	public function food_task_groups()
    {
        return $this->belongsTo('App\Model\FoodTaskGroups', 'group_id');
    }
  
      }