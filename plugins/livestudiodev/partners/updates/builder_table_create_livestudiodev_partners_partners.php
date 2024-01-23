<?php namespace LivestudioDev\Partners\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevPartnersPartners extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_partners_partners', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('livestudiodev_partners_partners');
    }
}
