<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCartitems extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_cartitems', function($table)
        {
            $table->string('product_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_cartitems', function($table)
        {
            $table->dropColumn('product_type');
        });
    }
}
