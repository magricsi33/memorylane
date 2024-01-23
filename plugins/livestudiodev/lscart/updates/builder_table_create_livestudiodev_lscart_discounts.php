<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartDiscounts extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_discounts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('active');
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->text('products');
            $table->decimal('discount', 10, 0);
            $table->integer('discount_type');
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_discounts');
    }
}
