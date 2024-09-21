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
                $beforeData = DB::table('mqtt_data_switch_unit_history_details AS mdshd')
                    ->leftJoin(
                        'mqtt_data_switch_unit_histories AS mdsh',
                        'mdsh.id',
                        '=',
                        'mdshd.history_id'
                    )
                    ->leftJoin(
                        'mqtt_data AS md',
                        'md.id',
                        '=',
                        'mdsh.mqtt_data_id'
                    )
                    ->where(function ($query) {
                        $query->whereNot(function ($q) {
                            $q->where('md.data_source', 'mqtt')
                                ->where('md.run_status', 'off');
                        });
                    })
                    ->where('mdshd.switch_type_id', $this->switch_type_id)
                    ->where('mdshd.number', $this->number)
                    ->where('mdshd.status', 'on')
                    ->where('mdshd.id', '<', $this->id)
                    /*->whereNot('id', $this->id)*/
                    /*->whereNot('history_id', $this->history_id)*/
                    ->orderByDesc('mdshd.id')
                    ->select('mdshd.*')
                    ->first();
                    if($this->number == 3) {
                        //dump("$this->id; $this->switch_type_id; " . json_encode($beforeData));
                    }
                $at = $beforeData?->created_at ? Carbon::parse($beforeData->created_at)->format('Y-m-d H:i:s') : null;
            } else {
                $at = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
            }
        } else if ($status === 'off') {
            if ($this->status == 'on') {
                $at = null;
            } else {
                $at = Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
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
        $startAt = Carbon::parse($this->machine_on_at);
        $endAt = Carbon::parse($this->machine_off_at);

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
