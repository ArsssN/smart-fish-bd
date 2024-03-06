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
        Schema::create('project_controller', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->references('id')->cascadeOnDelete();
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
        Schema::dropIfExists('controller_project');
    }
};
