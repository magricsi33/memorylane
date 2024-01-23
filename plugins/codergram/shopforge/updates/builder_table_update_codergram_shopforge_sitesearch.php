<?php namespace Codergram\Shopforge\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodergramShopforgeSitesearch extends Migration
{
    public function up()
    {
        Schema::table('codergram_shopforge_sitesearch', function($table)
        {
            $table->integer('view')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('codergram_shopforge_sitesearch', function($table)
        {
            $table->dropColumn('view');
        });
    }
}
