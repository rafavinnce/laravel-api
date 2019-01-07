<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShipmentShipments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_shipments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('wait_id');
            $table->unsignedInteger('dock_id');
            $table->unsignedInteger('carrier_id')->nullable();
            $table->unsignedInteger('load_id')->nullable();
            $table->string('box', 20)->nullable();

            $table->foreign('wait_id')
                ->references('id')->on('wait_waits');

            $table->foreign('dock_id')
                ->references('id')->on('dock_docks');

            $table->foreign('carrier_id')
                ->references('id')->on('carrier_carriers');

            $table->foreign('load_id')
                ->references('id')->on('shipment_loads');

            $table->timestamp('finish_at')->nullable();
            $table->timestamp('manifest_finish_at')->nullable();

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
        Schema::dropIfExists('shipment_shipments');
    }
}
