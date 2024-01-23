<?php namespace LivestudioDev\Partners\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLivestudiodevPartnersPartners extends Migration
{
    public function up()
    {
        Schema::table('livestudiodev_partners_partners', function($table)
        {
            $table->text('description');
        });
    }
    
    public function down()
    {
        Schema::table('livestudiodev_partners_partners', function($table)
        {
            $table->dropColumn('description');
        });
    }
}
