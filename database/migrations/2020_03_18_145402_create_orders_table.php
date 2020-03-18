<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('order_no')->default('0');
            $table->string('recipient_name')->default('0');
            $table->string('recipient_phone')->default('0');
            $table->string('recipient_address')->default('0');
            $table->string('shipment_time')->default('0');
            $table->integer('shipment_price')->nullable();
            $table->integer('total_price')->default('0');
            $table->string('shipment_status')->default('0');
            $table->string('payment_status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
