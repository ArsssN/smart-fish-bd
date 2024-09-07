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
            $table->text('original_data')->after('data')->nullable();  // Adding the original_data field
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
            $table->dropColumn('original_data');  // Dropping the column in case of rollback
        });
    }
};
