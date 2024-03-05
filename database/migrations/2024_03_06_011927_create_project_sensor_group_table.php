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
        Schema::create('project_sensor_group', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->references('id')->cascadeOnDelete();
            $table->foreignId('sensor_group_id')->constrained('sensor_groups')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sensor_group_project');
    }
};
