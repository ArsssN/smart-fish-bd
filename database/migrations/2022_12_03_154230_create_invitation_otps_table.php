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
        Schema::create('invitation_otps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invitation_id')->constrained('invitations')->references('id')->cascadeOnDelete();
            $table->string('otp', 8);
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invitation_otps');
    }
};
