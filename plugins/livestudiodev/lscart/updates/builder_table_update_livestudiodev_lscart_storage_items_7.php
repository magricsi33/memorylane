<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartStorageItems7 extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_storage_items', function($table)
        {
            $table->string('b_sku')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_storage_items', function($table)
        {
            $table->dropColumn('b_sku');
        });
    }
}
