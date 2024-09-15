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
        // Check and remove columns from switch_unit_switches table if they exist
        Schema::table('switch_unit_switches', function (Blueprint $table) {
            if (Schema::hasColumn('switch_unit_switches', 'run_status')) {
                $table->dropColumn('run_status');
            }
            if (Schema::hasColumn('switch_unit_switches', 'run_status_updated_at')) {
                $table->dropColumn('run_status_updated_at');
            }
        });

        // Check and add columns to switch_units table if they don't exist
        Schema::table('switch_units', function (Blueprint $table) {
            if (!Schema::hasColumn('switch_units', 'run_status')) {
                $table->enum('run_status', ['on', 'off'])->default('on')->comment('Switch status for running the switch');
            }
            if (!Schema::hasColumn('switch_units', 'run_status_updated_at')) {
                $table->timestamp('run_status_updated_at')->nullable()->comment('Switch status updated at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Check and add columns back to switch_unit_switches table if they don't exist
        Schema::table('switch_unit_switches', function (Blueprint $table) {
            if (!Schema::hasColumn('switch_unit_switches', 'run_status')) {
                $table->enum('run_status', ['on', 'off'])->default('on')->comment('Switch status for running the switch');
            }
            if (!Schema::hasColumn('switch_unit_switches', 'run_status_updated_at')) {
                $table->timestamp('run_status_updated_at')->nullable()->comment('Switch status updated at');
            }
        });

        // Check and remove columns from switch_units table if they exist
        Schema::table('switch_units', function (Blueprint $table) {
            if (Schema::hasColumn('switch_units', 'run_status')) {
                $table->dropColumn('run_status');
            }
            if (Schema::hasColumn('switch_units', 'run_status_updated_at')) {
                $table->dropColumn('run_status_updated_at');
            }
        });
    }
};
