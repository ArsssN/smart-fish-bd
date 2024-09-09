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
        Schema::create('switch_unit_switches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('switch_unit_id')->constrained('switch_units')->references('id')->cascadeOnDelete();

            $table->enum('number', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])->comment('Switch number');
            $table->foreignId('switchType')->constrained('switch_types')->references('id')->cascadeOnDelete();
            $table->enum('status', ['on', 'off'])->comment('Switch status');
            $table->text('comment')->nullable()->comment('Switch comment');

            // run_status
            $table->enum('run_status', ['on', 'off'])->default('on')->comment(
                'Switch status for running the switch'
            );
            $table->timestamp('run_status_updated_at')->nullable()->comment(
                'Switch status updated at'
            );

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
        Schema::dropIfExists('switch_unit_switches');
    }
};
