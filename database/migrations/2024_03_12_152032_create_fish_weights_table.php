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
        Schema::create('fish_weights', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('time');
            $table->foreignId('fish_id')->constrained('fishes')->references('id')->cascadeOnDelete();
            $table->decimal('weight', 8, 2)->default(0);
            $table->decimal('weight_in_24_hours', 8, 2)->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

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
        Schema::dropIfExists('fish_weights');
    }
};
