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
	public $username;
	public $display_name;
	public $password;
	 //join column	
public $role_id;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
 
	public function user_roles()
    {
        return $this->hasOne('App\Model\UserRoles');
    }
  
      }