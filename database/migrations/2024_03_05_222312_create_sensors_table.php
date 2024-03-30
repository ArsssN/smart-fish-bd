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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('serial_number', 100)->nullable();
            $table->string('slug', 191)->unique();
            $table->foreignId('sensor_type_id')->constrained('sensor_types')->references('id')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->foreignId('created_by')->comment(
                'Customer creates his own sensor'
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
        Schema::dropIfExists('sensors');
    }
};
