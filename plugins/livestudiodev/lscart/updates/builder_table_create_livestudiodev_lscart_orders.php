<?php namespace LivestudioDev\Lscart\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLivestudiodevLscartOrders extends Migration
{
    public function up()
    {
        Schema::create('livestudiodev_lscart_orders', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('billing_address')->nullable();
            $table->text('address')->nullable();
            $table->text('session_id')->nullable();
            $table->string('email')->nullable();
            $table->integer('status');
            $table->string('lang')->nullable();
            $table->string('order_number');
            $table->integer('cart_id')->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->text('infos')->nullable();
            $table->string('name')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('shipping_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('livestudiodev_lscart_orders');
    }
}
