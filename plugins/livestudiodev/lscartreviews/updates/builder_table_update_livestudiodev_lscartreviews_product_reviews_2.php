<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartreviewsProductReviews2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscartreviews_product_reviews', function($table)
        {
            $table->integer('variant_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscartreviews_product_reviews', function($table)
        {
            $table->dropColumn('variant_id');
        });
    }
}
