<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartPaymentMethods3 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->string('payment_gate')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->dropColumn('payment_gate');
        });
    }
}
