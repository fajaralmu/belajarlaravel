<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
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
	 public $code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 public $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 public $description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 public $url;
		
 	public $page_id;

	 /** 
	 *	@FormField(className="App\Models\Page",type="FIELD_TYPE_FIXED_LIST",lableName="Page",optionItemName="name",foreignKey="page_id")
	 */ 
		
 	public   Page $menuPage;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP" )
	 */ 
	 public $icon_url;

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
 

	 public function __construct(){
		 $this->menuPage = new Page();
	 }
 
	public function pages()
    {
        return $this->belongsTo('App\Model\Pages', 'page_id');
    }
  
      }