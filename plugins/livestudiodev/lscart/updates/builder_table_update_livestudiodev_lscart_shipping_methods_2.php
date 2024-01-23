<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartShippingMethods2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->integer('delivery_delay')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->dropColumn('delivery_delay');
        });
    }
}
