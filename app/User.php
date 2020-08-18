<?php

namespace App;

use App\Models\UserRole;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable; 

class User  extends Authenticatable 
{
	use Notifiable;
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT",emptyAble="false")
	 */ 
	 protected $username;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT",emptyAble="false")
	 */ 
	 protected $display_name;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT",emptyAble="false")
	 */ 
	 protected $password;
		
 	protected $role_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",optionItemName="name",foreignKey="role_id")
	 */ 
		
 	protected UserRole $role;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
	 */ 
	 protected $general_color;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
	 */ 
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
		return $this->attributes['username'];
	}
}