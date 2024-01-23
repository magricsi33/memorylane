<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartPropertables extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_propertables', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('property_id');
            $table->integer('propertable_id');
            $table->string('propertable_type');
            $table->text('propertable_value')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_propertables');
    }
}
