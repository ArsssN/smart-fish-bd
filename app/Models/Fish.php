<?php

namespace App\Models;

use AfzalSabbir\SlugGenerator\Traits\SlugGenerator;
use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fish extends Model
{
    use CrudTrait, SlugGenerator, CreatedByTrait, SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'fishes';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected array $slugGenerator = [
        "set-on-create" => true, // Whether to set the slug when the model is created
        "set-on-update" => false, // Whether to update the slug when the target field is updated
        "target-field"  => "name", // The field that will be used to generate the slug
        "separator"     => "-", // The separator that will be used to separate the words
        "slug-field"    => "slug", // The field that will be used to store the slug
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
     * Get all of the fishWeights for the Fish
     *
     * @return HasMany
     */
    public function fishWeights(): HasMany
    {
        return $this->hasMany(FishWeight::class);
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
