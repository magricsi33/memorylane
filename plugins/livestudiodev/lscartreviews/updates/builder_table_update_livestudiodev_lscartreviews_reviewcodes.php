<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartreviewsReviewcodes extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscartreviews_reviewcodes', function($table)
        {
            $table->boolean('used')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscartreviews_reviewcodes', function($table)
        {
            $table->dropColumn('used');
        });
    }
}
