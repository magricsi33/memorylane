<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartRelatedProducts extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_related_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('product_id');
            $table->integer('related_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_related_products');
    }
}