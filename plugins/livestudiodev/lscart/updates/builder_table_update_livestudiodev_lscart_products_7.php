<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartProducts7 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->decimal('supplier_price_netto', 10, 0)->nullable();
            $table->decimal('supplier_price_brutto', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_products', function($table)
        {
            $table->dropColumn('supplier_price_netto');
            $table->dropColumn('supplier_price_brutto');
        });
    }
}
