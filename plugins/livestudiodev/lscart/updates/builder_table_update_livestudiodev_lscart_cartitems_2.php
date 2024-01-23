<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCartitems2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_cartitems', function($table)
        {
            $table->integer('variant_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_cartitems', function($table)
        {
            $table->dropColumn('variant_id');
        });
    }
}
