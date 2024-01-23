<?php namespace Codergram\Slider\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramSliderSliders extends Migration
{
    public function up()
    {
        Schema::create('codergram_slider_sliders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->text('category')->nullable();
            $table->integer('sort_order')->nullable()->default(1);
            $table->integer('product_id')->nullable();
            $table->integer('blog_id')->nullable();
            $table->text('button')->nullable();
            $table->text('title')->nullable();
            $table->text('data')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_slider_sliders');
    }
}