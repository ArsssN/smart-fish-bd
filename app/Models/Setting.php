<?php

namespace App\Models;

use Backpack\Settings\app\Models\Setting as BackpackSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @mixin IdeHelperSetting
 */
class Setting extends BackpackSetting
{
    use HasFactory;
}
