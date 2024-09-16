<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperMqttData
 */
class MqttData extends Model
{
    use CrudTrait, CreatedByTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mqtt_data';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

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
     * Get the mqtt topic that owns the MqttData
     *
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(MqttDataHistory::class);
    }

    /**
     * Get the mqtt topic that owns the MqttData
     *
     * @return HasMany
     */
    public function switchUnitHistories(): HasMany
    {
        return $this->hasMany(MqttDataSwitchUnitHistory::class);
    }

    /**
     * Get the mqtt topic that owns the MqttData
     *
     * @return HasOne
     */
    public function switchUnitHistory(): HasOne
    {
        return $this->hasOne(MqttDataSwitchUnitHistory::class);
    }

    /**
     * Get the mqtt topic that owns the MqttData
     *
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
