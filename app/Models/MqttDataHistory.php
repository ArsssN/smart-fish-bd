<?php

namespace App\Models;

use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperMqttDataHistory
 */
class MqttDataHistory extends Model
{
    use CrudTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mqtt_data_histories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['new_value'];

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
     * Get the mqttData that owns the MqttDataHistory
     *
     * @return BelongsTo
     */
    public function mqttData(): BelongsTo
    {
        return $this->belongsTo(MqttData::class);
    }

    // pond
    public function pond()
    {
        return $this->belongsTo(Pond::class);
    }

    // sensor unit
    public function sensorUnit()
    {
        return $this->belongsTo(SensorUnit::class);
    }

    // sensor type
    public function sensorType()
    {
        return $this->belongsTo(SensorType::class);
    }

    // switch unit
    public function switchUnit()
    {
        return $this->belongsTo(SwitchUnit::class);
    }

    // switch type
    public function switchType()
    {
        return $this->belongsTo(SwitchType::class);
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
    public function getNewValueAttribute()
    {
        return $this->value;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
