<?php namespace Codergram\Zoldszeged\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramZoldszegedBlogs extends Migration
{
    public function up()
    {
        Schema::create('codergram_zoldszeged_blogs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('title');
            $table->text('intro')->nullable();
            $table->text('body')->nullable();
            $table->boolean('public')->default(0);
            $table->dateTime('public_start')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_zoldszeged_blogs');
    }
}
