<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
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
        'run_time'
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function getOnOffTime(MqttDataSwitchUnitHistoryDetail $modal, string $status)
    {
        $at = null;
        if ($status === 'on') {
            if ($modal->status == 'off') {
                $beforeData = DB::table('mqtt_data_switch_unit_history_details')
                    /*->whereNot('id', $modal->id)*/
                    /*->whereNot('history_id', $modal->history_id)*/
                    ->where('switch_type_id', $modal->switch_type_id)
                    ->where('number', $modal->number)
                    ->where('status', 'on')
                    ->orderByDesc('history_id')
                    ->first();
                $at = data_get($beforeData, 'created_at');
            } else {
                $at = $modal->created_at;
            }
        } else if ($status === 'off') {
            if ($this->status == 'on') {
                $at = null;
            } else {
                $at = $this->updated_at ?: $this->created_at;
            }
        }

        return $at;

    }

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
        return Attribute::make(
            get: fn() => $this->getOnOffTime($this, 'on'),
        );
    }

    // machineOffAt
    public function machineOffAt(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getOnOffTime($this, 'off'),
        );
    }

    // runtime in seconds
    public function runTime(): Attribute
    {
        $startAt = Carbon::parse($this->getOnOffTime($this, 'on'));
        $endAt = Carbon::parse($this->getOnOffTime($this, 'off'));

        $runTime = null;

        if ($startAt && $endAt) {
            $runTime = $startAt->diffInSeconds($endAt);
        } else if ($startAt) {
            $runTime = $startAt->diffInSeconds(now());
        } else if ($endAt) {
            $runTime = $endAt->diffInSeconds(now());
        }

        return Attribute::make(
            get: fn() => $runTime,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
