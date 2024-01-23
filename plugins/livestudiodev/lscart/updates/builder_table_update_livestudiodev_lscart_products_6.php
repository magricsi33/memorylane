<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartProducts6 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->integer('stock')->nullable()->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->dropColumn('stock');
        });
    }
}
