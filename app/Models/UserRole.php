<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 public $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 public $access;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 public $code;

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
 
   
      }