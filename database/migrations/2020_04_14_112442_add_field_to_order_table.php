<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('order_status_id')->after('note');
            $table->ipAddress('ip');
            $table->string('user_agent');
            $table->decimal('commission', 15, 4);
            $table->bigInteger('customer_id');
            $table->string('customer_email');
            $table->dropColumn('prices_regions_name');
            $table->dropColumn('current_status');
            $table->renameColumn('customer_phone', 'customer_phone_number');
            $table->renameColumn('cost', 'total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}
