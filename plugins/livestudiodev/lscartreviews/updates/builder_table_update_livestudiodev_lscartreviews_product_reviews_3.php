<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartreviewsProductReviews3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscartreviews_product_reviews', function($table)
        {
            $table->boolean('trimmable')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscartreviews_product_reviews', function($table)
        {
            $table->dropColumn('trimmable');
        });
    }
}
