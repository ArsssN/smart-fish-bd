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
        Schema::create('feeder_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feeder_id')->constrained('feeders')->references('id')->cascadeOnDelete();
            $table->date('date');
            $table->time('time');
            $table->decimal('run_time', 8, 2);
            $table->decimal('amount', 8, 2);
            $table->enum('unit', ['kg', 'g'])->default('kg');

            $table->foreignId('created_by')->nullable()->constrained('users')->references('id')->cascadeOnDelete();
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
        Schema::dropIfExists('feeder_histories');
    }
};
