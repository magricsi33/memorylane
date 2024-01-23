<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartProducts extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->integer('sort_order')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->integer('sort_order')->default(null)->change();
        });
    }
}
