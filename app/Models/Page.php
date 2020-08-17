<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

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
	 */ 
	 public $code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 public $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST",lableName="Authorized (yes:1 or no:0)",availableValues={0,1})
	 */ 
	 public $authorized;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST",lableName="Is Non-Menu Page (yes:1 or no:0)",availableValues={0,1})
	 */ 
	 public $is_non_menu_page;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT",lableName="Link for non menu page")
	 */ 
	 public $link;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 public $description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required="false")
	 */ 
	 public $image_url;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER",lableName="Urutan Ke")
	 */ 
	 public $sequence;

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