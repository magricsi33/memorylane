<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartPaymentMethods2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->integer('vatkey_id')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_payment_methods', function($table)
        {
            $table->dropColumn('vatkey_id');
        });
    }
}
