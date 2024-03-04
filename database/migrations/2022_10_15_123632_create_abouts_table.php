<?php

use App\Traits\AboutSchemaTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use AboutSchemaTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $this->aboutSchema($table);
        });

        Schema::table('abouts', function (Blueprint $table) {
            $table->boolean('is_in_home_button')->default(false);
            $table->boolean('is_in_home_card')->default(false);
            $table->string('home_card_icon', 191)->nullable();
            $table->string('home_card_description', 191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abouts');
    }
};
