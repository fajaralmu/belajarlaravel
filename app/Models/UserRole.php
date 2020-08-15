<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';
	public $name;
	public $access;
	public $code;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
   
      }