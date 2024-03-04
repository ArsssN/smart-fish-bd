<?php

namespace App\Traits;

trait AboutSchemaTrait
{
    use ReorderColumnsTrait;

    /**
     * @param $table
     * @return void
     */
    public function aboutSchema($table): void
    {
        $table->id();
        $table->string('title', 191 - 2);
        $table->string('slug', 191)->unique()->comment('Slug for the title');
        $table->text('sub_title')->nullable();
        $table->string('image', 191);
        $table->text('description')->nullable();
        $this->schema($table);
        $table->foreignId('created_by')->nullable()->constrained('users')->references('id')->cascadeOnDelete();
        $table->timestamps();
        $table->softDeletes();
    }
}
