<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartProductVariants extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_product_variants', function($table)
        {
            $table->integer('status')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_product_variants', function($table)
        {
            $table->dropColumn('status');
        });
    }
}
