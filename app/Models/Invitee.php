<?php

namespace App\Models;

use AfzalSabbir\SlugGenerator\Traits\SlugGenerator;
use App\Notifications\InviteeReminderNotification;
use App\Notifications\UserCreatedFromInviteeNotification;
use App\Traits\CreatedByTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Invitee extends Model
{
    use CrudTrait, Notifiable, SoftDeletes, SlugGenerator, CreatedByTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'invitees';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'id', 'created_by'];
    // protected $dates = [];
    protected array $slugGenerator = [
        'target-field' => 'name',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            self::createUser($model);
        });
    }

    /**
     * @param $model
     * @return void
     */
    private static function createUser($model): void
    {
        if (canUserBeCreatedFromInvitee()) {
            $userName = uniqueUserNameFromEmail($model->email);
            $userData = [
                'name'     => $model->name,
                'password' => bcrypt($userName),
                'username' => $userName,
            ];
            $where    = [
                'email' => $model->email,
            ];

            $user = User::query()->firstOrCreate($where, $userData);

            if ($user->wasRecentlyCreated) {
                $user->notify(new UserCreatedFromInviteeNotification());
            }

            $model->user_id = $user->id;
            $model->save();
        }
    }

    /**
     * @return void
     */
    public function sendReminder(): void
    {
        $this->notify(new InviteeReminderNotification());
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return HasOne
     */
    public function invitation(): HasOne
    {
        return $this->hasOne(Invitation::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
