<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperProjectSensor
 */
class ProjectSensor extends Model
{
    use HasFactory;

    protected $table = 'project_sensor';
}
