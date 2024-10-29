<?php

namespace Sambu\Ecommerce\Models\Geo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Sambu\Ecommerce\Traits\HasAnotherPrimaryKey;

/**
 * @method static where(string $string, $value)
 */
abstract class AbstractGeoModel extends Model
{
    use SoftDeletes, HasAnotherPrimaryKey;

    public function __construct(array $attributes = [])
    {
        $this->setTable($this->getTable());
        parent::__construct($attributes);
    }

    public function getTable()
    {
        $name = Str::lower(class_basename($this));
        return config("ecommerce.migration.{$name}_table.name");
    }

    public static function findByCode($value)
    {
        return self::where('code', $value)->first();
    }

    public static function findByName($value)
    {
        return self::where('name', $value)->first();
    }
}
