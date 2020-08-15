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
	public $request_id;
	public $value;
	public $referrer;
	public $user_agent;
	public $ip_address;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
   
      }