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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('invitee_id')->constrained('invitees')->references('id')->cascadeOnDelete();
            $table->string('code', 16)->unique();
            $table->foreignId('event_id')->constrained('events')->references('id')->cascadeOnDelete();
            $table->text('card')->comment('The card that was sent to the invitee.');

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
        Schema::dropIfExists('invitations');
    }
};
