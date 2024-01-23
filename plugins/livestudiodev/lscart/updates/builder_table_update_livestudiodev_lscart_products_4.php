<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartProducts4 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->dropColumn('currency_id');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->integer('currency_id');
        });
    }
}
