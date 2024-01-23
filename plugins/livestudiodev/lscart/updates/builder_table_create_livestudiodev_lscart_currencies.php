<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartCurrencies extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_currencies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('label');
            $table->string('code');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_currencies');
    }
}
