<?php

namespace App\Traits;

trait ReorderColumnsTrait
{
    /**
     * @param $table
     * @return void
     */
    public function schema($table): void
    {
        $table->foreignId('parent_id')->nullable()->default(0)/*->constrained($table->getTable())*/->cascadeOnDelete();
        $table->integer('lft')->nullable()->default(0);
        $table->integer('rgt')->nullable()->default(0);
        $table->integer('depth')->nullable()->default(0);
    }
}
