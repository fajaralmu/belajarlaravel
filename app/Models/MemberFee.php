<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberFee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_fees';
	 //join column	
public $member_id;
	public $month;
	public $year;
	public $nominal;
	public $fee_type;
	public $transaction_date;
	public $week;
	public $decription;
	public $id;
	public $created_date;
	public $modified_date;
	public $deleted;
	public $general_color;
	public $font_color;

 
	public $created_at, $updated_at;
 
 
	public function members()
    {
        return $this->hasOne('App\Model\Members');
    }
  
      }