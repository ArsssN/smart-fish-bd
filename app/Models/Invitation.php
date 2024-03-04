<?php

namespace App\Models;

use App\Helpers\InvitationCardHelper;
use App\Http\Controllers\InvitationController;
use App\Notifications\InvitationCreateNotification;
use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use CrudTrait, SoftDeletes, CreatedByTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public string $urlBase = '/invitation';

    protected $table = 'invitations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'event_id', 'invitee_id', 'id', 'created_by'];
    // protected $dates = [];
    protected $casts   = [
        'card' => 'array',
    ];
    protected $appends = [
        /*'invitee_name',
        'event_title',*/
        'code_event_invitee',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->card = (new InvitationCardHelper)->generate($model->event, $model->invitee);
        });

        static::created(function ($model) {
            $url = url(config('app.frontend_base_url') . $model->urlBase);
            $url .= "?code=$model->code";
            $model->invitee->notify(new InvitationCreateNotification($model, $url));
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsTo
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo
     */
    public function invitee(): BelongsTo
    {
        return $this->belongsTo(Invitee::class);
    }

    /**
     * @return HasOne
     */
    public function invitationOtp(): HasOne
    {
        return $this->hasOne(InvitationOtp::class);
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
    public function getInviteeNameAttribute(): string
    {
        return $this->invitee->name;
    }

    /**
     * @return string
     */
    public function getEventTitleAttribute(): string
    {
        return $this->event->title;
    }

    /**
     * @return string
     */
    public function getCodeEventInviteeAttribute(): string
    {
        return $this->code . ' - ' . $this->event->title . ' - ' . $this->invitee->name;
    }

    /**
     * @return string
     */
    /*public function getCardAttribute(): string
    {
        return $this->attributes['card']
            ? asset($this->attributes['card'])
            : '';
    }*/

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    /*public function setInviteeIdAttribute($value)
    {
        $event   = Event::query()->find($value);
        $invitee = Invitee::query()->find($this->attributes['invitee_id']);

        $this->attributes['invitee_id'] = $value;
        $this->attributes['card']       = (new InvitationCardHelper)->generate($event, $invitee);
    }*/
}
