<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST",lableName="Authorized (yes:1 or no:0)",availableValues="0,1")
	 */ 
	 protected $authorized;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST",lableName="Is Non-Menu Page (yes:1 or no:0)",availableValues="0,1")
	 */ 
	 protected $is_non_menu_page;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT",lableName="Link for non menu page")
	 */ 
	 protected $link;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required="false")
	 */ 
	 protected $image_url;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER",lableName="Urutan Ke")
	 */ 
	 protected $sequence;

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