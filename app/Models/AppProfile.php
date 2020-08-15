<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppProfile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'app_profiles';
	 protected $name;
	 protected $app_code;
	 protected $short_description;
	 protected $about;
	 protected $welcoming_message;
	 protected $address;
	 protected $contact;
	 protected $website;
	 protected $icon_url;
	 protected $background_url;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 

    public function setDec($dec){
        $this->short_description = $dec;
    }
   
      }