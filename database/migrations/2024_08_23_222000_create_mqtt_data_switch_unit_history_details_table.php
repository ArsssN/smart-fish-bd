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
        Schema::create('mqtt_data_switch_unit_history_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_id')->constrained('mqtt_data_switch_unit_histories')->cascadeOnDelete();
            $table->enum('number', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
            $table->foreignId('switch_type_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['on', 'off'])->default('off');
            $table->text('comment')->nullable();

            // runtime
            $table->dateTime('on_at')->nullable();
            $table->dateTime('off_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mqtt_data_switch_unit_history_details');
    }
};
