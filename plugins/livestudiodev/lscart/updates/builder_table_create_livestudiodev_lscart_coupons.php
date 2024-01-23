<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartCoupons extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_coupons', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->dateTime('end_date')->nullable();
            $table->boolean('alluser');
            $table->boolean('allcategory');
            $table->text('categories');
            $table->text('users')->nullable();
            $table->string('code')->nullable();
            $table->string('value_type');
            $table->integer('value');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_coupons');
    }
}
