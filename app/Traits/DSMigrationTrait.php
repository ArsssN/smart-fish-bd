<?php

namespace App\Traits;

use App\Models\DSUser;

trait DSMigrationTrait
{
    protected $table, $connection;

    public function __construct()
    {
        $builder          = app($this->modelClass ?? abort(404, 'No model class defined'));
        $this->table      = $builder->getTable();
        $this->connection = $builder->getConnectionName();
    }
}
