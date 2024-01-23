<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartStorageItems2 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_storage_items', function($table)
        {
            $table->string('type')->nullable();
            $table->string('brand')->nullable();
            $table->integer('price_brutto')->default(0)->change();
            $table->integer('price_netto')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_storage_items', function($table)
        {
            $table->dropColumn('type');
            $table->dropColumn('brand');
            $table->integer('price_brutto')->default(null)->change();
            $table->integer('price_netto')->default(null)->change();
        });
    }
}
