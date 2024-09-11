<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mqtt_data', function (Blueprint $table) {
            $table->enum('data_source', ['mqtt', 'api', 'scheduler', 'test'])->after('data')->default('mqtt');
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
            $table->dropColumn('data_source');
        });
    }
};
