<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShipmentSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_steps', function (Blueprint $table) {
            $table->increments('id');

            $table->mediumInteger('percent')->nullable();
            $table->timestamp('updated_picking_at')->nullable();

            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('status_status')->onDelete('set null');
            $table->integer('shipment_id')->unsigned()->nullable();
            $table->foreign('shipment_id')->references('id')->on('shipment_shipments')->onDelete('cascade');
            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('status_status')->onDelete('set null');
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->foreign('invoice_id')->references('id')->on('status_status')->onDelete('set null');

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
        Schema::dropIfExists('shipment_steps');
    }
}
