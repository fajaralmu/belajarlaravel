<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class AppProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_profiles';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_HIDDEN")
	 */ 
	 protected $app_code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $short_description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $about;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $welcoming_message;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $address;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $contact;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $website;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required="false")
	 */ 
	 protected $icon_url;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultBackground.BMP",required="false")
	 */ 
	 protected $background_url;

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