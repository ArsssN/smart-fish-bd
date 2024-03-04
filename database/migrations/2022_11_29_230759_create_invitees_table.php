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
        Schema::create('invitees', function (Blueprint $table) {
            $table->id();

            $table->string('name', 191 - 2);
            $table->string('slug', 191);
            $table->string('email', 191);
            $table->string('phone', 20);
            $table->text('address');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

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
        Schema::dropIfExists('invitees');
    }
};
