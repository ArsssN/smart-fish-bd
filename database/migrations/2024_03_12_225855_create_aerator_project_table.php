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
        Schema::create('aerator_project', function (Blueprint $table) {
            $table->foreignId('aerator_id')->constrained('aerators')->references('id')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aerator_project');
    }
};
