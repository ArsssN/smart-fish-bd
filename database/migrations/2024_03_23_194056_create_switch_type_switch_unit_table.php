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
        Schema::create('switch_type_switch_unit', function (Blueprint $table) {
            $table->foreignId('switch_type_id')->constrained('switch_types')->references('id')->cascadeOnDelete();
            $table->foreignId('switch_unit_id')->constrained('switch_units')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('switch_type_switch_unit');
    }
};
