<?php

use App\Models\Pricing;
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
        Schema::create('pricings', function (Blueprint $table) {
            $table->id();

            $table->string('title', 191 - 2);
            $table->string('slug', 191)->unique();
            $table->float('price', 7);
            $table->enum('currency', Pricing::CURRENCY)->default('bdt');
            $table->text('description')->nullable();
            $table->enum('card_bg_color', array_keys(Pricing::CARD_BG_COLOR))->default('bg-white');

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
        Schema::dropIfExists('pricings');
    }
};
