<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartDiscounts extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_discounts', function($table)
        {
            $table->dropColumn('discount_type');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_discounts', function($table)
        {
            $table->integer('discount_type');
        });
    }
}
