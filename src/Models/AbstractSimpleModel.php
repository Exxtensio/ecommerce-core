<?php

namespace Sambu\Ecommerce\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Sambu\Ecommerce\Traits\HasAnotherPrimaryKey;

/**
 * @method static where(string $string, $value)
 */
abstract class AbstractSimpleModel extends Model
{
    use HasAnotherPrimaryKey;

    public function __construct(array $attributes = [])
    {
        $this->setTable($this->getTable());
        parent::__construct($attributes);
    }

    public function getTable()
    {
        $name = Str::snake(class_basename($this));
        return config("ecommerce.migration.{$name}_table.name");
    }
}
