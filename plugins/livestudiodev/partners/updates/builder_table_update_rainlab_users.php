<?php namespace LivestudioDev\Partners\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateRainlabUsers extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('company')->nullable();
            $table->string('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('phone')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('company');
            $table->dropColumn('address');
            $table->dropColumn('tax_number');
            $table->dropColumn('phone');
        });
    }
}
