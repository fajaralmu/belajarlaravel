<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User  extends Authenticatable 
{
	use Notifiable;
	// use  Authenticatable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    	protected $table = 'users';
	 protected $username;
	 protected $display_name;
	 protected $password;
	 //join column	
	public $role_id;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color; 
	public $created_at, $updated_at; 
 
	public function user_roles()
    {
        return $this->belongsTo('App\Model\UserRoles', 'role_id');
    }
	public function getAuthPassword()
    {	
		$pwd =  $this->attributes['password']; 
        return $pwd;
	}
	
	public function getAuthIdentifierName(){ 
		return "username";
	}

	public function getAuthIdentifier(){ 
		return $this->username;
	}
}