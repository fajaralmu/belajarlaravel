

<?php 

//////////////////scheduled_food_task_groups////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateScheduledFoodTaskGroupsTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('scheduled_food_task_groups', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->unsignedBigInteger('group_member_id'); 
		 $table->foreign('group_member_id')->references('id')->on('food_task_group_members'); 
		$table->integer('day'); 
		$table->integer('month'); 
		$table->integer('year'); 
		$table->string('meal_time'); 
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
        Schema::dropIfExists('scheduled_food_task_groups');
    }
}