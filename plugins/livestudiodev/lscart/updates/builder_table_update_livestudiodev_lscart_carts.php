<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCarts extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_carts', function($table)
        {
            $table->integer('status')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_carts', function($table)
        {
            $table->integer('status')->default(null)->change();
        });
    }
}
