

<?php 

//////////////////pages////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('pages', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->string('code')->unique(); 
		$table->string('name')->unique(); 
		$table->string('authorized'); 
		$table->string('is_non_menu_page'); 
		$table->string('link')->unique(); 
		$table->text('description'); 
		$table->text('image_url'); 
		$table->integer('sequence'); 
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
        Schema::dropIfExists('pages');
    }
}