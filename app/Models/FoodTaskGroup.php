<?php

namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column; 

class FoodTaskGroup extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'food_task_groups';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $id;
	
	/**
	 
	 * @Column() 
	 */
	 protected $created_date;
	
	/**
	 
	 * @Column() 
	 */
	 protected $modified_date;
	
	/**
	 
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
 
   
      }