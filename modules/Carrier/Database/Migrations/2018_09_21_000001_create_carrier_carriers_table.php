<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarrierCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrier_carriers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->integer('id_external')->unique();
            $table->boolean('is_casual')->default(true);
            $table->time('operation_start',8)->nullable();
            $table->time('operation_end',8)->nullable();
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
        Schema::dropIfExists('carrier_carriers');
    }
}