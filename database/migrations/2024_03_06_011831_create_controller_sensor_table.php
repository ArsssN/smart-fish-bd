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
        Schema::create('controller_sensor', function (Blueprint $table) {
            $table->foreignId('sensor_id')->constrained('sensors')->references('id')->cascadeOnDelete();
            $table->foreignId('controller_id')->constrained('controllers')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controller_sensor');
    }
};
