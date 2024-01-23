<?php namespace Codergram\Shopforge\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramShopforgePages extends Migration
{
    public function up()
    {
        Schema::create('codergram_shopforge_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->date('public_date')->nullable();
            $table->text('name')->nullable();
            $table->text('body')->nullable();
            $table->text('category')->nullable();
            $table->integer('sort_order')->nullable()->default(1);
            $table->text('slug')->nullable();
            $table->text('code')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_shopforge_pages');
    }
}
