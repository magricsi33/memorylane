<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartProducts extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('cikkszam')->nullable();
            $table->decimal('price', 10, 0)->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('vatkey_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->text('extras')->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('active');
            $table->integer('currency_id');
            $table->text('slug');
            $table->decimal('price_brutto', 10, 0)->nullable();
            $table->integer('sort_order');
            $table->text('meta_title')->nullable();
            $table->text('properties')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_products');
    }
}
