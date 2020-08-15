

<?php 

//////////////////member_fees////////////////
 use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateMemberFeesTable extends Migration
{
    /**
     * Run the migrations.
      *
      * @return void
     */
    public function up()
    { 
  Schema::create('member_fees', function (Blueprint $table) {
            
		$table->bigIncrements('id'); 
		$table->unsignedBigInteger('member_id'); 
		 $table->foreign('member_id')->references('id')->on('members'); 
		$table->integer('month'); 
		$table->integer('year'); 
		$table->integer('nominal'); 
		$table->string('fee_type'); 
		$table->timestamp('transaction_date', 0)->nullable(); 
		$table->integer('week'); 
		$table->text('decription'); 
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
        Schema::dropIfExists('member_fees');
    }
}