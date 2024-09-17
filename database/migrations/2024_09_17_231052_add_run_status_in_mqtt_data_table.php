<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mqtt_data', function (Blueprint $table) {
            $table->enum('run_status', ['on', 'off'])->after('publish_topic')->default('on')->comment(
                'Run Status'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mqtt_data', function (Blueprint $table) {
            $table->dropColumn('run_status');
        });
    }
};
