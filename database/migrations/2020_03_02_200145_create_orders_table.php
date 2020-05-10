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
            // $table->string('prices_regions_name');
            $table->decimal('delivery_cost', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->text('note')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->string('customer_email');
            $table->string('customer_phone_number');
            $table->string('customer_name');
            $table->text('customer_address');
            $table->bigInteger('current_status');
            // $table->ipAddress('visitor_ip');
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
