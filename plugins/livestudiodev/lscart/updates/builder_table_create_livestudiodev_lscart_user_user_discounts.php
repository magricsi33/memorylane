<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartUserUserDiscounts extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_user_user_discounts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->integer('userdiscount_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_user_user_discounts');
    }
}
