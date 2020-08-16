<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $url;
		
 protected $page_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Page",optionItemName="name",foreignKey="page_id")
	 */ 
		
 protected  Models\Page $menuPage;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required="false")
	 */ 
	 protected $icon_url;

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
 
 
	public function pages()
    {
        return $this->belongsTo('App\Model\Pages', 'page_id');
    }
  
      }