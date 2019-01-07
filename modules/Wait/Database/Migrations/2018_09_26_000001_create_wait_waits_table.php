<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitWaitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wait_waits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver', 100);
            $table->string('manifest', 32);
            $table->string('seal1', 32)->nullable();
            $table->string('seal2', 32)->nullable();
            $table->string('authorized_by', 100)->nullable();
            $table->timestamp('arrival_at')->nullable();
            $table->timestamp('entry_at')->nullable();
            $table->timestamp('output_at')->nullable();
            $table->integer('operation_id')->unsigned()->nullable();
            $table->foreign('operation_id')->references('id')->on('operation_operations')->onDelete('set null');
            $table->integer('board_horse_id')->unsigned()->nullable();
            $table->foreign('board_horse_id')->references('id')->on('vehicle_vehicles')->onDelete('set null');
            $table->integer('board_cart_id')->unsigned()->nullable();
            $table->foreign('board_cart_id')->references('id')->on('vehicle_vehicles')->onDelete('set null');
            $table->integer('carrier_id')->unsigned()->nullable();
            $table->foreign('carrier_id')->references('id')->on('carrier_carriers')->onDelete('set null');
            $table->integer('lobby_id')->unsigned()->nullable();
            $table->foreign('lobby_id')->references('id')->on('lobby_lobbies')->onDelete('set null');
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
        Schema::dropIfExists('wait_waits');
    }
}