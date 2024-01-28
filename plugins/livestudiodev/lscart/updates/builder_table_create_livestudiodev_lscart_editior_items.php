<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartEditiorItems extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_editior_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('name')->nullable();
            $table->text('code')->nullable();
            $table->text('data')->nullable();
            $table->integer('editior_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_editior_items');
    }
}