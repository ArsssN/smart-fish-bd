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

class Project extends Model
{
    use CrudTrait, SlugGenerator, CreatedByTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'projects';
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
     * Get the user that owns the Project
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the project that owns the Controller
     *
     * @return BelongsToMany
     */
    public function Controllers(): BelongsToMany
    {
        return $this->belongsToMany(Controller::class);
    }

    /**
     * Get the project that owns the Feeder
     *
     * @return BelongsToMany
     */
    public function sensors(): BelongsToMany
    {
        return $this->belongsToMany(Sensor::class, 'project_sensor', 'project_id', 'sensor_id');
    }

    /**
     * Get the project that owns the Aerator
     *
     * @return BelongsToMany
     */
    public function aerators(): BelongsToMany
    {
        return $this->belongsToMany(Aerator::class, 'aerator_project');
    }

    /**
     * Get the project that owns the Feeder
     *
     * @return BelongsToMany
     */
    public function feeders(): BelongsToMany
    {
        return $this->belongsToMany(Feeder::class, 'feeder_project');
    }

    /**
     * @return HasMany
     */
    public function ponds(): HasMany
    {
        return $this->hasMany(Pond::class);
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
