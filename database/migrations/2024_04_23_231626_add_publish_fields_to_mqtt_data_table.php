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
        Schema::table('mqtt_data', function (Blueprint $table) {
            $table->text('publish_message')->comment(
                'The data to be published to the MQTT'
            )->nullable()->after('data');

            $table->text('publish_topic')->comment(
                'The topic to be published to the MQTT'
            )->nullable()->after('publish_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mqtt_data', function (Blueprint $table) {
            $table->dropColumn('publish_message');
            $table->dropColumn('publish_topic');
        });
    }
};
