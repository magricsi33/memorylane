<?php namespace Codergram\Zoldszeged\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateCodergramZoldszegedBlogs extends Migration
{
    public function up()
    {
        Schema::table('codergram_zoldszeged_blogs', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('codergram_zoldszeged_blogs', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
