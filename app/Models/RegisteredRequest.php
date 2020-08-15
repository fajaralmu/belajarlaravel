<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisteredRequest extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registered_requests';
	 protected $request_id;
	 protected $value;
	 protected $referrer;
	 protected $user_agent;
	 protected $ip_address;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 
   
      }