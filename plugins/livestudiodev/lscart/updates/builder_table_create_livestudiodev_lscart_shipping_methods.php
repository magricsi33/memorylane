<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartShippingMethods extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->boolean('active');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('prices')->nullable();
            $table->text('payments')->nullable();
            $table->integer('postapont');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_shipping_methods');
    }
}
