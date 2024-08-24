<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSensorTypeSensorUnit
 */
class SensorTypeSensorUnit extends Model
{
    use HasFactory;

    protected $table = 'sensor_type_sensor_unit';
}
