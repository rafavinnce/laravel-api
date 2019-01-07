<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlertsToUserUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_users', function (Blueprint $table) {
            $table->boolean('is_alert_phone')->default(false);
            $table->boolean('is_alert_mail')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_users', function(Blueprint $table) {
            $table->dropColumn(['is_alert_phone', 'is_alert_mail']);
        });
    }
}
