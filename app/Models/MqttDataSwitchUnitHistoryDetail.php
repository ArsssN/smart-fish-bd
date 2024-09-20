<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @mixin IdeHelperMqttDataSwitchUnitHistoryDetail
 */
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
                $at = $beforeData?->created_at ? Carbon::parse($beforeData->created_at)->format('Y-m-d H:i:s') : null;
            } else {
                $at = Carbon::parse($modal->created_at)->format('Y-m-d H:i:s');
            }
        } else if ($status === 'off') {
            if ($modal->status == 'on') {
                $at = null;
            } else {
                $at = Carbon::parse($modal->updated_at ?: $modal->created_at)->format('Y-m-d H:i:s');
            }
        } else {
            $at = null;
        }

        return $at;

    }

    public function setAppendsManually(array $appends): void
    {
        $this->appends = $appends;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return BelongsTo
     */
    public function switchType(): BelongsTo
    {
        return $this->belongsTo(SwitchType::class);
    }

    /**
     * @return BelongsTo
     */
    public function mqttDataSwitchUnitHistory(): BelongsTo
    {
        return $this->belongsTo(MqttDataSwitchUnitHistory::class, 'history_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * @param Builder $query
     * @return void
     */
    public function scopeWithoutAppends(Builder $query): void
    {
        $this->setAppends([]);
    }

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
