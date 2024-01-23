<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartreviewsReviewcodes extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscartreviews_reviewcodes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('code');
            $table->integer('order_id');
            $table->dateTime('expires_at')->nullable();
            $table->boolean('expires')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscartreviews_reviewcodes');
    }
}
