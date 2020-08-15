<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menus';
	 protected $code;
	 protected $name;
	 protected $description;
	 protected $url;
	 //join column	
public $page_id;
	 protected $icon_url;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 
 
	public function pages()
    {
        return $this->belongsTo('App\Model\Pages', 'page_id');
    }
  
      }