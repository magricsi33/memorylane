<?php namespace Codergram\Zoldszeged\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramZoldszegedPages extends Migration
{
    public function up()
    {
        Schema::create('codergram_zoldszeged_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->text('sections')->nullable();
            $table->boolean('public')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_zoldszeged_pages');
    }
}
