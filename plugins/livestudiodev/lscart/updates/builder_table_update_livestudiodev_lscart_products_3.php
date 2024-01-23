<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartProducts3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->integer('status');
            $table->dropColumn('active');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->dropColumn('status');
            $table->boolean('active');
        });
    }
}
