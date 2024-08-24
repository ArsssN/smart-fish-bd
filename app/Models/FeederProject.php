<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperFeederProject
 */
class FeederProject extends Model
{
    use HasFactory;

    protected $table = 'feeder_project';
}
