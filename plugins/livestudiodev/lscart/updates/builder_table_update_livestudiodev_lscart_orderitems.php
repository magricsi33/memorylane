<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartOrderitems extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_orderitems', function($table)
        {
            $table->string('product_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_orderitems', function($table)
        {
            $table->dropColumn('product_type');
        });
    }
}
