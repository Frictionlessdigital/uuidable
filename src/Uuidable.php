<?php

namespace Fls\Uuidable;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait Uuidable
{
    /**
     * Boot the trait by adding observers.
     *
     * @return void
     */
    public static function bootUuidable()
    {
        static::creating(function (Model $model) {
            $model->{$model->getUuidColumn()} = $model->{$model->getUuidColumn()} ?? (string) Str::uuid();
        });
    }

    /**
     * Resolve UUID field name.
     *
     * @return string
     */
    public function getUuidColumn(): string
    {
        return defined('static::UUID') ? constant('static::UUID') : 'uuid';
    }

    /**
     * Get fully-qualified column name.
     *
     * @return string
     */
    public function getQualifiedUuidColumn(): string
    {
        return $this->qualifyColumn($this->getUuidColumn());
    }

    /**
     * First the value by their Uuid.
     *
     * @param string $uuid
     * @return Builder
     */
    public static function findByUuid(string $uuid, array $columns = ['*']): ?Model
    {
        return static::query()->whereUuid($uuid)->first($columns);
    }

    /**
     * Scope the value by their Uuid.
     *
     * @param Builder $builder
     * @param string|array|Collection|Arrayable $uuid
     * @return Builder
     */
    public function scopeWhereUuid(Builder $builder, $uuid): Builder
    {
        if ($uuid instanceof Collection) {
            $uuid = $uuid->modelKeys();
        }

        if ($uuid instanceof Arrayable) {
            $uuid = $uuid->toArray();
        }

        return $builder->whereIn($this->getQualifiedUuidColumn(), Arr::wrap($uuid));
    }
}
