<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartProductVariants extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_product_variants', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('product_id');
            $table->double('pricediff', 10, 4)->nullable();
            $table->string('sku')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_product_variants');
    }
}
