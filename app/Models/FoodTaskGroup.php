<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodTaskGroup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'food_task_groups';
	public $name;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
   
      }