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
        Schema::create('mqtt_data_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mqtt_data_id')->constrained('mqtt_data')->cascadeOnDelete();
            $table->foreignId('pond_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sensor_unit_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('sensor_type_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('switch_unit_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('switch_type_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('value')->comment(
                'The value of the data'
            );
            $table->text('message')->comment(
                'The message of the data using the value from the helper method'
            );

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
        Schema::dropIfExists('mqtt_data_histories');
    }
};
