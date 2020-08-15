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
	 protected $code;
	 protected $name;
	 protected $authorized;
	 protected $is_non_menu_page;
	 protected $link;
	 protected $description;
	 protected $image_url;
	 protected $sequence;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 
   
      }