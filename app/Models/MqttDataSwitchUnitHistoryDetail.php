<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
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

    // getMachineOnAt
    private function getMachineOnAt()
    {
        if ($this->status == 'off') {
            $beforeData = DB::table('mqtt_data_switch_unit_history_details')
                /*->whereNot('id', $this->id)*/
                /*->whereNot('history_id', $this->history_id)*/
                ->where('switch_type_id', $this->switch_type_id)
                ->where('number', $this->number)
                ->where('status', 'on')
                ->where('id', '<', $this->id)
                ->orderByDesc('id')
                ->first(['created_at', 'id']);
            return [$beforeData?->created_at ? Carbon::parse($beforeData?->created_at)->format('Y-m-d H:i:s') : null, $beforeData?->id];
        } else {
            return [Carbon::parse($this->created_at)->format('Y-m-d H:i:s'), $this->id];
        }
    }

    // getMachineOffAt
    private function getMachineOffAt()
    {
        if ($this->status == 'on') {
            $beforeData = DB::table('mqtt_data_switch_unit_history_details')
                /*->whereNot('id', $this->id)*/
                /*->whereNot('history_id', $this->history_id)*/
                ->where('switch_type_id', $this->switch_type_id)
                ->where('number', $this->number)
                //->where('status', 'on')
                ->where('id', '>', $this->id)
                ->orderBy('id')
                ->first(['created_at', 'id']);
            return [$beforeData?->created_at ? Carbon::parse($beforeData?->created_at)->format('Y-m-d H:i:s') : null, $beforeData?->id];
        } else {
            return [Carbon::parse($this->created_at)->format('Y-m-d H:i:s'), $this->id];
        }
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

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    // machineOnAt
    public function machineOnAt(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMachineOnAt(),
        );
    }

    // machineOffAt
    public function machineOffAt(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getMachineOffAt(),
        );
    }

    // runtime in seconds
    public function runTime(): Attribute
    {
        $startAt = Carbon::parse($this->getMachineOnAt()[0]);
        $endAt = Carbon::parse($this->getMachineOffAt()[0]);

        $runTime = null;

        if ($startAt && $endAt) {
            $runTime = $startAt->diffInSeconds($endAt);
        } else if ($startAt && !$endAt) {
            $runTime = $startAt->diffInSeconds(now());
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
