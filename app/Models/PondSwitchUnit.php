<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperPondSwitchUnit
 */
class PondSwitchUnit extends Model
{
    use HasFactory;

    protected $table = 'pond_switch_unit';
}
