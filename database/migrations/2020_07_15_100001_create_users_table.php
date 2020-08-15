

<?php 

//////////////////users////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('users', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->string('username')->unique(); 
		$table->string('display_name'); 
		$table->string('password'); 
		$table->unsignedBigInteger('role_id'); 
		 $table->foreign('role_id')->references('id')->on('user_roles'); 
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
        Schema::dropIfExists('users');
    }
}