<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class MqttDataSwitchUnitHistoryDetail extends Model
{
    use CrudTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'mqtt_data_switch_unit_history_details';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = [
        'machine_on_at',
        'machine_off_at',
        'runtime'
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
    // machineOnAt
    public function machineOnAt(): Attribute
    {
        if ($this->status == 'off') {
            $beforeData = DB::table('mqtt_data_switch_unit_history_details')
                /*->whereNot('id', $this->id)*/
                /*->whereNot('history_id', $this->history_id)*/
                ->where('switch_type_id', $this->switch_type_id)
                ->where('number', $this->number)
                ->where('status', 'on')
                ->orderByDesc('history_id')
                ->first();
            $onAt = data_get($beforeData, 'created_at');
        } else {
            $onAt = $this->created_at;
        }

        return Attribute::make(
            get: fn() => $onAt,
        );
    }
    // machineOffAt
    public function machineOffAt(): Attribute
    {
        if ($this->status == 'on') {
            $offAt = null;
        } else {
            $offAt = $this->updated_at ?: $this->created_at;
        }

        return Attribute::make(
            get: fn() => $offAt,
        );
    }

    // runtime
    public function runtime(): Attribute
    {
        dd($this);
        return Attribute::make(
            get: function () {
                $onAt = $this->machineOnAt;
                $offAt = $this->machineOffAt;

                if ($onAt && $offAt) {
                    return $onAt->diff($offAt);
                }

                return null;
            },
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
