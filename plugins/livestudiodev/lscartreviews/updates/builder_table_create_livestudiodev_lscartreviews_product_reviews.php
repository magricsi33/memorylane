<?php namespace LivestudioDev\Lscartreviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartreviewsProductReviews extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscartreviews_product_reviews', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('order_id')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('star', 10, 5);
            $table->boolean('accepted')->default(0);
            $table->integer('product_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscartreviews_product_reviews');
    }
}
