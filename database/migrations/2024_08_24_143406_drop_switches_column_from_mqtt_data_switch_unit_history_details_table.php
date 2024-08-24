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
    public function up(): void
    {
        Schema::table('mqtt_data_switch_unit_history_details', function (Blueprint $table) {
            if (Schema::hasColumn('mqtt_data_switch_unit_history_details', 'switches')) {
                $table->dropColumn('switches');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('mqtt_data_switch_unit_history_details', function (Blueprint $table) {
            if (!Schema::hasColumn('mqtt_data_switch_unit_history_details', 'switches')) {
                $table->string('switches'); // Adjust the column type if it was different
            }
        });
    }
};
