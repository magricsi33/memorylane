<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartCurrencies extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_currencies', function($table)
        {
            $table->string('shortcode')->nullable();
            $table->double('exchange_value', 10, 5)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_currencies', function($table)
        {
            $table->dropColumn('shortcode');
            $table->dropColumn('exchange_value');
        });
    }
}
