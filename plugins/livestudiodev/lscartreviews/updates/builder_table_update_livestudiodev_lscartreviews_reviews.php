<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartreviewsReviews extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscartreviews_reviews', function($table)
        {
            $table->double('star', 10, 5)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscartreviews_reviews', function($table)
        {
            $table->dropColumn('star');
        });
    }
}
