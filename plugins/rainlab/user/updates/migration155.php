<?php namespace RainLab\User\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration155 extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->text('billings')->nullable();
            $table->text('shipping')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('billings');
            $table->dropColumn('shipping');
        });
    }
}