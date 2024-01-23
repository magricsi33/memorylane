<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartShippingMethods extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->dropColumn('postapont');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_shipping_methods', function($table)
        {
            $table->integer('postapont');
        });
    }
}
