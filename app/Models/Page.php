<?php

namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column; 

class Page extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST",lableName="Authorized (yes:1 or no:0)",availableValues= {0,1} )
	  
	 
	 * @Column() 
	 */
	 protected $authorized;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST",lableName="Is Non-Menu Page (yes:1 or no:0)",availableValues= {0,1} )
	  
	 
	 * @Column() 
	 */
	 protected $is_non_menu_page;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT",lableName="Link for non menu page")
	  
	 
	 * @Column() 
	 */
	 protected $link;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required=false)
	  
	 
	 * @Column() 
	 */
	 protected $image_url;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER",lableName="Urutan Ke")
	  
	 
	 * @Column() 
	 */
	 protected $sequence;

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