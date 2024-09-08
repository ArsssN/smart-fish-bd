<?php

namespace App\Models;

use AfzalSabbir\SlugGenerator\Traits\SlugGenerator;
use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSwitchUnit
 */
class SwitchUnit extends Model
{
    use CrudTrait, SlugGenerator, CreatedByTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'switch_units';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected array $slugGenerator = [
        "set-on-create" => true, // Whether to set the slug when the model is created
        "set-on-update" => false, // Whether to update the slug when the target field is updated
        "target-field" => "name", // The field that will be used to generate the slug
        "separator" => "-", // The separator that will be used to separate the words
        "slug-field" => "slug", // The field that will be used to store the slug
    ];
    protected $casts = [
        // 'switches' => 'array',
    ];
    protected $appends = [
        'switches'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the project that owns the Controller
     *
     * @return BelongsToMany
     */
    public function switchTypes(): BelongsToMany
    {
        return $this->belongsToMany(SwitchType::class, 'switch_type_switch_unit');
    }

    /**
     * Get the project that owns the Controller
     *
     * @return BelongsToMany
     */
    public function ponds(): BelongsToMany
    {
        return $this->belongsToMany(Pond::class);
    }

    /**
     * Get the project that owns the Controller
     *
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(MqttDataSwitchUnitHistory::class);
    }

    /**
     * Get the project that owns the Controller
     *
     * @return HasMany
     */
    public function switchUnitSwitches(): HasMany
    {
        return $this->hasMany(SwitchUnitSwitch::class);
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the project that owns the Controller
     *
     * @return array
     */
    public function getSwitchesAttribute(): array
    {
        return (
            $this->switchUnitSwitches?->map(function ($switch) {
                return [
                    'number' => $switch->number,
                    'switchType' => $switch->switchType,
                    'status' => $switch->status,
                    'comment' => $switch->comment,
                ];
            })
            ?? collect()
        )->toArray();
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
