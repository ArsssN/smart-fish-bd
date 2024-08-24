<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperControllerSensor
 */
class ControllerSensor extends Model
{
    use HasFactory;

    protected $table = 'controller_sensor';
}
