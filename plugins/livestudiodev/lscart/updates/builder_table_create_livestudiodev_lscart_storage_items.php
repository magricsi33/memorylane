<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartStorageItems extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_storage_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('name');
            $table->integer('product_id')->nullable();
            $table->string('partner')->nullable();
            $table->integer('storage')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_storage_items');
    }
}
