<?php

namespace Exxtensio\EcommerceCore\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Exxtensio\EcommerceCore\Traits\HasAnotherPrimaryKey;

/**
 * @method static where(string $string, $value)
 */
abstract class AbstractProductModel extends Model
{
    use SoftDeletes, HasAnotherPrimaryKey;

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
