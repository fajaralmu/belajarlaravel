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
	public $code;
	public $name;
	public $description;
	public $url;
	 //join column	
public $page_id;
	public $icon_url;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
 
	public function pages()
    {
        return $this->hasOne('App\Model\Pages');
    }
  
      }