<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevLscartStorageItems extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_lscart_storage_items', function($table)
        {
            $table->text('description')->nullable();
            $table->string('cikkszam')->nullable();
            $table->integer('price_brutto');
            $table->integer('price_netto');
            $table->text('image_link')->nullable();
            $table->text('image')->nullable();
            $table->text('gallery_links')->nullable();
            $table->integer('category_id')->nullable();
            $table->renameColumn('storage', 'stock');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_lscart_storage_items', function($table)
        {
            $table->dropColumn('description');
            $table->dropColumn('cikkszam');
            $table->dropColumn('price_brutto');
            $table->dropColumn('price_netto');
            $table->dropColumn('image_link');
            $table->dropColumn('image');
            $table->dropColumn('gallery_links');
            $table->dropColumn('category_id');
            $table->renameColumn('stock', 'storage');
        });
    }
}
