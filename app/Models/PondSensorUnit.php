<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPondSensorUnit
 */
class PondSensorUnit extends Model
{
    use HasFactory;

    protected $table = 'pond_sensor_unit';
}
