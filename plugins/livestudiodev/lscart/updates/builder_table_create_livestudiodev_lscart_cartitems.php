<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartCartitems extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_cartitems', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('cart_id');
            $table->integer('quantity');
            $table->integer('product_id');
            $table->integer('sort_order')->nullable();
            $table->text('extras')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_cartitems');
    }
}
