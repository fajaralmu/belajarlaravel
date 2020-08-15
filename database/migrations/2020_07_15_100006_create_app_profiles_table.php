

<?php 

//////////////////app_profiles////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateAppProfilesTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('app_profiles', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->string('name'); 
		$table->string('app_code')->unique(); 
		$table->text('short_description'); 
		$table->text('about'); 
		$table->text('welcoming_message'); 
		$table->text('address'); 
		$table->text('contact'); 
		$table->string('website'); 
		$table->text('icon_url'); 
		$table->text('background_url'); 
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
        Schema::dropIfExists('app_profiles');
    }
}