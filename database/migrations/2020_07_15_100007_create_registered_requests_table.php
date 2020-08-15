

<?php 

//////////////////registered_requests////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateRegisteredRequestsTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('registered_requests', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->string('request_id'); 
		$table->string('value'); 
		$table->string('referrer'); 
		$table->string('user_agent'); 
		$table->string('ip_address'); 
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
        Schema::dropIfExists('registered_requests');
    }
}