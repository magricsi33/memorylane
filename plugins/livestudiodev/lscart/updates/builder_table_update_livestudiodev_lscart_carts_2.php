<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCarts2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_carts', function($table)
        {
            $table->integer('currency_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_carts', function($table)
        {
            $table->dropColumn('currency_id');
        });
    }
}
