

<?php 

//////////////////food_task_group_members////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateFoodTaskGroupMembersTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('food_task_group_members', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->unsignedBigInteger('group_id'); 
		 $table->foreign('group_id')->references('id')->on('food_task_groups'); 
		$table->integer('sequence')->unique(); 
		$table->string('member_identities'); 
		$table->timestamp('created_date', 0)->nullable(); 
		$table->timestamp('modified_date', 0)->nullable(); 
		$table->string('deleted'); 
		$table->string('general_color'); 
		$table->string('font_color'); 
		$table->timestamps(); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_task_group_members');
    }
}