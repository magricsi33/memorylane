<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartVatkeys extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_vatkeys', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->decimal('value', 10, 0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_vatkeys');
    }
}
