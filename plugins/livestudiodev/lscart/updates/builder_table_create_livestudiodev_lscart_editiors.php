<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartEditiors extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_editiors', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('product_id');
            $table->integer('variant_id');
            $table->text('datas');
            $table->integer('cartitem_id')->nullable();
            $table->boolean('finish')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_editiors');
    }
}