<?php namespace Codergram\Shopforge\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramShopforgeSubscribers extends Migration
{
    public function up()
    {
        Schema::create('codergram_shopforge_subscribers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('theme')->nullable();
            $table->boolean('active')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_shopforge_subscribers');
    }
}
