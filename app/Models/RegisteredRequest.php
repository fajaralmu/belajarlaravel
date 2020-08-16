<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class RegisteredRequest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registered_requests';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $request_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $value;
	 protected $referrer;
	 protected $user_agent;
	 protected $ip_address;

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
 
   
      }