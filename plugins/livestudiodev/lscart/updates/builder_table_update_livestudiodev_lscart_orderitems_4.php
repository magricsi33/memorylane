<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartOrderitems4 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_orderitems', function($table)
        {
            $table->integer('editior_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_orderitems', function($table)
        {
            $table->dropColumn('editior_id');
        });
    }
}
