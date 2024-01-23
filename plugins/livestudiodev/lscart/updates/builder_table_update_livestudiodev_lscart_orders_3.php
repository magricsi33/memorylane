<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartOrders3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_orders', function($table)
        {
            $table->text('history')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_orders', function($table)
        {
            $table->dropColumn('history');
        });
    }
}
