<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartOrders extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_orders', function($table)
        {
            $table->integer('status')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_orders', function($table)
        {
            $table->integer('status')->default(null)->change();
        });
    }
}
