<?php

namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column; 

class MemberFee extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'member_fees';

		 /**
	 * @Column() 
 */  		
 protected $member_id;

	 /** 
	 *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Member",optionItemName="name",className="App\Models\Member",foreignKey="member_id")
	 */ 
		
 protected   Member $member;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $month;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $year;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $nominal;

	 /** 
	 *	@FormField(type="FIELD_TYPE_PLAIN_LIST", availableValues={"WATER", "OTHER"})
	  
	 
	 * @Column() 
	 */
	 protected $fee_type;

	 /** 
	 *	@FormField(type="FIELD_TYPE_DATE")
	  
	 
	 * @Column() 
	 */
	 protected $transaction_date;

	 /** 
	 *	@FormField(type="FIELD_TYPE_NUMBER")
	  
	 
	 * @Column() 
	 */
	 protected $week;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXTAREA")
	  
	 
	 * @Column() 
	 */
	 protected $decription;

	 /** 
	 *	@FormField(type="FIELD_TYPE_TEXT")
	  
	 
	 * @Column() 
	 */
	 protected $id;
	
	/**
	 
	 * @Column() 
	 */
	 protected $created_date;
	
	/**
	 
	 * @Column() 
	 */
	 protected $modified_date;
	
	/**
	 
	 * @Column() 
	 */
	 protected $deleted;

	//  /** 
	//  *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
	  
	 
	//  * @Column() 
	//  */
	//  protected $general_color;

	//  /** 
	//  *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
	  
	 
	//  * @Column() 
	//  */
	//  protected $font_color;

 
	/**
	 * @Column() 
	*/
	 protected $created_at; 
	/**
	 * @Column() 
	*/ 
	protected $updated_at;
 
 
	public function members()
    {
        return $this->belongsTo('App\Model\Members', 'member_id');
    }
  
      }