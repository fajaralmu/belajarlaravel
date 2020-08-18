<?php
namespace App\Models;

use App\Annotations\FormField;
use App\Annotations\Column;

class FoodTaskGroupMember extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'food_task_group_members';

    /**
     * @Column()
     */
    protected $group_id;

    /** 
     *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Group",optionItemName="name",className="App\Models\FoodTaskGroup",foreignKey="group_id")
     */

    protected FoodTaskGroup $group;

    /** 
     *	@FormField(type="FIELD_TYPE_FIXED_LIST",lableName="Member",optionItemName="name",multipleSelect=true, className="App\Models\Member", foreignKey="member_identities")
     */
    public array $members;
    /** 
     *	@FormField(type="FIELD_TYPE_NUMBER")
     * @Column()
     */
    protected $sequence;

    /** 
    * @Column()
    */
    protected $member_identities;

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

    // /** 
    //  *	@FormField(type="FIELD_TYPE_COLOR",lableName="Background Color",defaultValue="#ffffff")
    //  * @Column()
    //  */
    // protected $general_color;

    // /** 
    //  *	@FormField(type="FIELD_TYPE_COLOR",defaultValue="#000000")
    //  * @Column()
    //  */
    // protected $font_color;

    /**
     * @Column()
     */
    protected $created_at;
    /**
     * @Column()
     */
    protected $updated_at;

    public function food_task_groups()
    {
        return $this->belongsTo('App\Model\FoodTaskGroups', 'group_id');
    }

}

