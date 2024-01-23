<?php namespace Codergram\Shopforge\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateCodergramShopforgeSitesearch extends Migration
{
    public function up()
    {
        Schema::create('codergram_shopforge_sitesearch', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('codergram_shopforge_sitesearch');
    }
}
