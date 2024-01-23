<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartProperties extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_properties', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('type');
            $table->text('extra')->nullable();
            $table->string('filter_type')->nullable();
            $table->string('filter_unit')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_properties');
    }
}
