<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperMqttDataSwitchUnitHistory
 */
class MqttDataSwitchUnitHistory extends Model
{
    use CrudTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mqtt_data_switch_unit_histories';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
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

    // switch unit
    public function switchUnit()
    {
        return $this->belongsTo(SwitchUnit::class);
    }

    /**
     * Get the mqtt topic that owns the MqttData
     *
     * @return HasMany
     */
    public function switchUnitHistoryDetails(): HasMany
    {
        return $this->hasMany(MqttDataSwitchUnitHistoryDetail::class, 'history_id', 'id');
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

    //switches
    public function switches(): Attribute
    {
        $switches = $this->switchUnitHistoryDetails->map(function ($switchUnitHistoryDetail) {
            return [
                'number' => $switchUnitHistoryDetail->number,
                'switchType' => $switchUnitHistoryDetail->switch_type_id,
                'status' => $switchUnitHistoryDetail->status,
                'comment' => $switchUnitHistoryDetail->comment,
            ];
        });

        return Attribute::make(
            get: fn() => $switches
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
