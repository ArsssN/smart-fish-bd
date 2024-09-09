<?php

namespace App\Models;

use AfzalSabbir\SlugGenerator\Traits\SlugGenerator;
use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperSensorType
 */
class SensorType extends Model
{
    use CrudTrait, SlugGenerator, CreatedByTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sensor_types';
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
    protected $appends = [];

    /**
     * @var array|string[] $defaultSensors - Default sensors for the machine report
     */
    public static array $defaultSensors = ['o2', 'temp', 'tds', 'ph'];
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
     * @return HasMany
     */
    public function sensors(): HasMany
    {
        return $this->hasMany(Sensor::class);
    }

    /**
     * Get the project that owns the Controller
     *
     * @return BelongsToMany
     */
    public function sensorUnits(): BelongsToMany
    {
        return $this->belongsToMany(SensorUnit::class, 'sensor_type_sensor_unit');
    }

    /**
     * Get the project that owns the Controller
     *
     * @return HasManyThrough
     */
    public function projects(): HasManyThrough
    {
        return $this->hasManyThrough(Project::class, Sensor::class);
    }

    /**
     * Get the mqtt data history that owns the SensorType
     *
     * @return HasMany
     */
    public function mqttDataHistories(): HasMany
    {
        return $this->hasMany(MqttDataHistory::class);
    }

    /**
     * Get the mqtt data history that owns the SensorType
     *
     * @return HasOne
     */
    public function mqttDataHistory(): HasOne
    {
        return $this->hasOne(MqttDataHistory::class)->orderByDesc('id');
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
    // average
    public function getAvgAttribute()
    {
        /*$lastDate = Carbon::make('2024-05-10')->startOfDay();
        $laterDate = Carbon::make('2024-05-10')->endOfDay();*/

        $lastDate = Carbon::now()->subDay();
        $laterDate = Carbon::now();

        $mqttDataHistory = $this->mqttDataHistories()
            ->whereBetween('created_at', [$lastDate, $laterDate])
            ->whereNotNull('value')
            ->where('value', "!=", "")
            ->get();

        return number_format(+($mqttDataHistory->average('value') ?? 0), 2);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
