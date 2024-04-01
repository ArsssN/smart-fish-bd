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
        Schema::create('mqtt_data', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sensor', 'switch'])->comment(
                'The type of the data'
            );
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            $table->text('data')->comment(
                'The data from the MQTT response'
            );

            $table->foreignId('created_by')->comment(
                'History created by the user'
            )->nullable()->constrained('users')->references('id')->cascadeOnDelete();
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
        Schema::dropIfExists('mqtt_data');
    }
};
