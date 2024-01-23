<?php namespace Codergram\Zoldszeged\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodergramZoldszegedPages extends Migration
{
    public function up()
    {
        Schema::table('codergram_zoldszeged_pages', function($table)
        {
            $table->string('menu_name')->nullable();
            $table->boolean('show_menu')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('codergram_zoldszeged_pages', function($table)
        {
            $table->dropColumn('menu_name');
            $table->dropColumn('show_menu');
        });
    }
}
