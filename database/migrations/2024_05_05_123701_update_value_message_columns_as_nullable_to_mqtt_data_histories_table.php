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
        Schema::table('mqtt_data_histories', function (Blueprint $table) {
            $table->string('value')->nullable()->change();
            $table->text('message')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mqtt_data_histories', function (Blueprint $table) {
            $table->string('value')->nullable(false)->change();
            $table->text('message')->nullable(false)->change();
        });
    }
};
