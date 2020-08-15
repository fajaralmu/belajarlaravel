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
	 protected $month;
	 protected $year;
	 protected $nominal;
	 protected $fee_type;
	 protected $transaction_date;
	 protected $week;
	 protected $decription;
	 protected $id;
	 protected $created_date;
	 protected $modified_date;
	 protected $deleted;
	 protected $general_color;
	 protected $font_color;

 
	public $created_at, $updated_at;
 
 
	public function members()
    {
        return $this->belongsTo('App\Model\Members', 'member_id');
    }
  
      }