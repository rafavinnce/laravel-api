<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShipmentPendencies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_pendencies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name', 100);
            $table->string('assigned_by', 100)->nullable();
            $table->timestamp('finish_at')->nullable();

            $table->integer('shipment_id')->unsigned()->nullable();
            $table->foreign('shipment_id')->references('id')->on('shipment_shipments')->onDelete('cascade');
            $table->integer('step_id')->unsigned()->nullable();
            $table->foreign('step_id')->references('id')->on('shipment_steps')->onDelete('cascade');

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
        Schema::dropIfExists('shipment_pendencies');
    }
}
