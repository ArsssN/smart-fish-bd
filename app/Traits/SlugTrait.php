<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait SlugTrait
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootSlugTrait()
    {
        static::creating(function ($model) {
            if ($model->slug['setOnCreate'] ?? true) {
                $model->handle($model);
            }
        });

        static::updating(function ($model) {
            if ($model->slug['setOnUpdate'] ?? true) {
                $model->handle($model);
            }
        });
    }

    /**
     * @param Model $model
     * @return void
     */
    public function handle(Model $model)
    {
        $slugField   = $model->slug['slugField'] ?? 'slug';
        $targetField = $model->slug['targetField'] ?? 'title';
        $separator   = $model->slug['separator'] ?? '-';

        $model->generateSlug(null, $slugField, $targetField, $separator);
    }

    /**
     * @param string|null $value
     * @param string $slugField
     * @param string $targetField
     * @param string $separator
     * @return string
     */
    protected function generateSlug(string $value = null, string $slugField = 'slug', string $targetField = 'name', string $separator = '-'): string
    {
        $value = $value ?? $this->attributes[$targetField];
        $slug  = Str::slug($value, $separator);

        $count = $this->query()
            ->where('id', '!=', $this->attributes['id'] ?? null)
            ->whereRaw("$slugField RLIKE '^$slug(-[0-9]+)?$'")
            ->count();

        $slug = $count
            ? "$slug-$count"
            : $slug;

        $this->attributes[$slugField] = $slug;

        return $slug;
    }
}
