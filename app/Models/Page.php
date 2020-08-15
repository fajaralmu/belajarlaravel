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
	public $code;
	public $name;
	public $authorized;
	public $is_non_menu_page;
	public $link;
	public $description;
	public $image_url;
	public $sequence;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
   
      }