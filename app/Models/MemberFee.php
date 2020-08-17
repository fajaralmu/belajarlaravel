<?php

namespace App\Models;

use App\Annotations\FormField;
 use Illuminate\Database\Eloquent\Model;

class MemberFee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_fees';
		
 public $member_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Member",optionItemName="name",foreignKey="member_id")
	 */ 
		
 public  Member $member;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $month;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $year;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $nominal;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST")
	 */ 
	 public $fee_type;

	 /** 
	 *	@FormField(type="FIELD_TYPE_DATE")
	 */ 
	 public $transaction_date;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 public $week;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 public $decription;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	 */ 
	protected $id;
	 public $created_date;
	 public $modified_date;
	 public $deleted;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
	 */ 
	 public $general_color;

	 /** 
	 *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
	 */ 
	 public $font_color;

 
	 protected $created_at, $updated_at;
 
 
	public function members()
    {
        return $this->belongsTo('App\Model\Members', 'member_id');
    }
  
      }