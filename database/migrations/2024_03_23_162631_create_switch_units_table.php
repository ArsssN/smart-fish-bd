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
        Schema::create('switch_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('serial_number', 100)->nullable();
            $table->string('slug', 191)->unique();
            $table->text('switches')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->foreignId('created_by')->comment(
                'Customer creates his own sensor unit'
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
        Schema::dropIfExists('switch_units');
    }
};
