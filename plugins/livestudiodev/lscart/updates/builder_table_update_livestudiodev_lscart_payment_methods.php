<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartPaymentMethods extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->integer('billingo_type')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->dropColumn('billingo_type');
        });
    }
}
