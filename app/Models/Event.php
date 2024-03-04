<?php

namespace App\Models;

use AfzalSabbir\SlugGenerator\Traits\SlugGenerator;
use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use CrudTrait, SoftDeletes, CreatedByTrait, SlugGenerator;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const REMINDER = [
        'daily'    => 1,
        '2 days'   => 2,
        '3 days'   => 3,
        'weekly'   => 7,
        'monthly'  => 30,
        '3 months' => 90,
        '6 months' => 180,
        '9 months' => 270,
        'yearly'   => 365,
    ];
    const STATUS   = [
        'active', // Open
        'canceled', // Will Never be Opened
        'expired', // Event End Date Passed
    ];
    protected $table = 'events';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'id', 'created_by', 'owned_by'];
    // protected $dates = [];
    protected $casts   = [
        'banner'       => 'string',
        'card_details' => 'array',
        'start_date'   => 'datetime',
        'end_date'     => 'datetime',
    ];
    protected $appends = ['title_location_date', 'is_active'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getApiHidden()
    {
        return $this->api_hidden;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owned_by', 'id');
    }

    /**
     * @return HasMany
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
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
    /**
     * @return string
     */
    public function getTitleLocationDateAttribute(): string
    {
        return $this->title . ' - ' . $this->location
               . ' (' . $this->start_date->format('d M, Y h:ma') . ' - ' . $this->end_date->format('d M, Y h:ma') . ')';
    }

    /**
     * @return bool
     */
    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
