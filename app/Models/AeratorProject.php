<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAeratorProject
 */
class AeratorProject extends Model
{
    use HasFactory;

    protected $table = 'aerator_project';
}
