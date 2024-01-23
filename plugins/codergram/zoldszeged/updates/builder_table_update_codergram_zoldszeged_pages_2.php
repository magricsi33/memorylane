<?php namespace Codergram\Zoldszeged\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodergramZoldszegedPages2 extends Migration
{
    public function up()
    {
        Schema::table('codergram_zoldszeged_pages', function($table)
        {
            $table->string('show_footer')->default('0');
        });
    }
    
    public function down()
    {
        Schema::table('codergram_zoldszeged_pages', function($table)
        {
            $table->dropColumn('show_footer');
        });
    }
}
