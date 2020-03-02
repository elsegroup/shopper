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
            $table->string('prices_regions_name');
            $table->decimal('delivery_cost', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->text('note');
            $table->boolean('current_status');
            $table->text('cancel_reason');
            $table->string('customer_phone'); // TODO: придумать что-то лучшее
            $table->string('customer_name');
            $table->text('delivery_address');
            $table->ipAddress('visitor');
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
