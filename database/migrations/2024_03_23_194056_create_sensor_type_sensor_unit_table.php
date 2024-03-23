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
        Schema::create('sensor_type_sensor_unit', function (Blueprint $table) {
            $table->foreignId('sensor_type_id')->constrained('sensor_types')->references('id')->cascadeOnDelete();
            $table->foreignId('sensor_unit_id')->constrained('sensor_units')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_type_sensor_unit');
    }
};
