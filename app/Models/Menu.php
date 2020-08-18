<?php

namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column; 

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
	  
	 
	 * @Column() 
	 */
	 protected $code;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $description;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $url;

		 /**
	 * @Column() 
 */  		
 protected $page_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Page",optionItemName="name",className="App\Models\Page",foreignKey="page_id")
	 */ 
		
 protected   Page $menuPage;

	 /** 
	 *	@FormField(type="FIELD_TYPE_IMAGE",defaultValue="DefaultIcon.BMP",required=false)
	  
	 
	 * @Column() 
	 */
	 protected $icon_url;

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
 
 
	public function pages()
    {
        return $this->belongsTo('App\Model\Pages', 'page_id');
    }
  
      }