<?php

namespace Sambu\Ecommerce\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

trait HasAnotherPrimaryKey
{
    public function initializeHasAnotherPrimaryKey(): void
    {
        if(config('ecommerce.migration.primary') === 'id') $this->usesUniqueIds = false;
        else $this->usesUniqueIds = true;
    }

    public function uniqueIds(): array
    {
        return [$this->getKeyName()];
    }

    public function newUniqueId(): ?string
    {
        if(config('ecommerce.migration.primary') === 'uuid') {
            return Str::orderedUuid()->toString();
        } else if (config('ecommerce.migration.primary') === 'ulid') {
            return strtolower(Str::ulid()->toString());
        }
        return null;
    }

    /**
     * @param $query
     * @param $value
     * @param $field
     * @return Builder
     */
    public function resolveRouteBindingQuery($query, $value, $field = null): Builder
    {
        if(config('ecommerce.migration.primary') === 'ulid') {
            if ($field && in_array($field, $this->uniqueIds()) && ! Str::isUlid($value)) {
                throw (new ModelNotFoundException)->setModel(get_class($this), $value);
            }

            if (! $field && in_array($this->getRouteKeyName(), $this->uniqueIds()) && ! Str::isUlid($value)) {
                throw (new ModelNotFoundException)->setModel(get_class($this), $value);
            }
        } else if (config('ecommerce.migration.primary') === 'uuid') {
            if ($field && in_array($field, $this->uniqueIds()) && ! Str::isUuid($value)) {
                throw (new ModelNotFoundException)->setModel(get_class($this), $value);
            }

            if (! $field && in_array($this->getRouteKeyName(), $this->uniqueIds()) && ! Str::isUuid($value)) {
                throw (new ModelNotFoundException)->setModel(get_class($this), $value);
            }
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    public function getKeyType(): string
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) {
            return 'string';
        }

        return $this->keyType;
    }

    public function getIncrementing(): bool
    {
        if (in_array($this->getKeyName(), $this->uniqueIds())) return false;
        return $this->incrementing;
    }
}
