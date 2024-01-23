<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartreviewsReviews3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscartreviews_reviews', function($table)
        {
            $table->integer('order_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscartreviews_reviews', function($table)
        {
            $table->integer('order_id')->nullable(false)->change();
        });
    }
}
