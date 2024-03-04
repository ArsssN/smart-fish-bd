<?php

use App\Traits\ReorderColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use ReorderColumnsTrait;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_link_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title', 191 - 2)->unique();
            $table->string('slug', 191)->unique();
            $table->enum('position', ['top', 'bottom'])->default('top');
            $this->schema($table);

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
        Schema::dropIfExists('footer_link_groups');
    }
};
