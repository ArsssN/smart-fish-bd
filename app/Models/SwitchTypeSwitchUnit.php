<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSwitchTypeSwitchUnit
 */
class SwitchTypeSwitchUnit extends Model
{
    use HasFactory;

    protected $table = 'switch_type_switch_unit';
}
