<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartPaymentMethods extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_payment_methods');
    }
}
