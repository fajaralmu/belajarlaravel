<?php

namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column; 

class AppProfile extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_profiles';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_HIDDEN")
	  
	 
	 * @Column() 
	 */
	 protected $app_code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $short_description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $about;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $welcoming_message;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $address;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $contact;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $website;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required=false)
	  
	 
	 * @Column() 
	 */
	 protected $icon_url;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultBackground.BMP",required=false)
	  
	 
	 * @Column() 
	 */
	 protected $background_url;

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
 
   
      }