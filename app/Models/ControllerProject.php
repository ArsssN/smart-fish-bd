<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperControllerProject
 */
class ControllerProject extends Model
{
    use HasFactory;

    protected $table = 'controller_project';
}
