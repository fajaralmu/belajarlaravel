<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
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
  
      }