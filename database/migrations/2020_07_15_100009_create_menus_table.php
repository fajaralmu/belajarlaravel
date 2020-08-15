

<?php 

//////////////////menus////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('menus', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->string('code')->unique(); 
		$table->string('name')->unique(); 
		$table->text('description'); 
		$table->string('url')->unique(); 
		$table->unsignedBigInteger('page_id'); 
		 $table->foreign('page_id')->references('id')->on('pages'); 
		$table->text('icon_url'); 
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
        Schema::dropIfExists('menus');
    }
}