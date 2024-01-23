<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartreviewsReviews2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscartreviews_reviews', function($table)
        {
            $table->boolean('accepted')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscartreviews_reviews', function($table)
        {
            $table->dropColumn('accepted');
        });
    }
}
