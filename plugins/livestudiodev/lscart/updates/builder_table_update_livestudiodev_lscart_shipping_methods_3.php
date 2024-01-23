<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartShippingMethods3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->integer('vatkey_id')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->dropColumn('vatkey_id');
        });
    }
}
