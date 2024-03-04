<?php

use App\Models\Event;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('title', 191 - 2);
            $table->string('slug', 191);
            $table->text('description');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('location');
            $table->set('reminder', Event::REMINDER)->default(1)
                ->comment('Every [1: 1 day before, 2: 2 days before, 3: 3 days before, 4: 4 days before, 5: 5 days before, 6: 6 days before, 7: 7 days before] the event');
            $table->string('banner', 191)->nullable();
            $table->text('card_details');
            //$table->boolean('is_active')->default(false);
            $table->enum('status', Event::STATUS)->default('active');
            $table->foreignId('owned_by')->nullable()->constrained('users')->references('id')->cascadeOnDelete();

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
        Schema::dropIfExists('events');
    }
};
