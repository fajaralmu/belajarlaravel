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
		
 protected $member_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Member",optionItemName="name",foreignKey="member_id")
	 */ 
		
 protected  Member $member;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $month;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $year;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $nominal;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST")
	 */ 
	 protected $fee_type;

	 /** 
	 *	@FormField(type="FIELD_TYPE_DATE")
	 */ 
	 protected $transaction_date;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	 */ 
	 protected $week;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	 */ 
	 protected $decription;

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
 
 
	public function members()
    {
        return $this->belongsTo('App\Model\Members', 'member_id');
    }
  
      }