<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShipmentLoads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_loads', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamp('datetime');
            $table->integer('sales_order');
            $table->string('item_code', 32);
            $table->string('load_status_start', 2);
            $table->string('wave', 12);
            $table->smallInteger('billing_warehouse');
            $table->string('pre_number', 12);
            $table->integer('carrier_id')->unsigned()->nullable();
            $table->foreign('carrier_id')->references('id')->on('carrier_carriers')->onDelete('set null');
            $table->string('dispatch_route', 12);
            $table->integer('customer_code');
            $table->integer('load_number');
            $table->string('load_status', 2);
            $table->integer('amount');
            $table->integer('volumes');
            $table->decimal('order_cubing', 8, 2);

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
        Schema::dropIfExists('shipment_loads');
    }
}
