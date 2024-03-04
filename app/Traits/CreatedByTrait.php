<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait CreatedByTrait
{
    /**
     * Boot the created by trait for a model.
     * It will add user id in created_by field who create the model.
     *
     * @return void
     */
    public static function bootCreatedByTrait()
    {
        $admin_id = (backpack_auth()->user()
                     ?? User::query()
                         ->where('is_admin', true)
                         ->first())->id
                    ?? null;

        static::creating(function ($model) use ($admin_id) {
            ($model->created_by = $admin_id) ?? abort(404);
        });

        static::updating(function ($model) use ($admin_id) {
            ($model->created_by = $model->created_by ?? $admin_id) ?? abort(404);
        });
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
