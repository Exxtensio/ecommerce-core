<?php

namespace Exxtensio\EcommerceCore\Providers\Includes;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 * @method id()
 * @method ulid(string $string)
 * @method uuid(string $string)
 * @method unsignedBigInteger(string $string)
 * @method index(string[] $array, string $string)
 * @method primary(string[] $array, string $string)
 * @method foreign(string $string)
 */
class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->blueprintMacro();
    }

    public function register(): void {}

    protected function blueprintMacro(): void
    {
        Blueprint::macro('ecommercePrimary', function () {
            if(config('ecommerce.migration.primary') === 'id') {
                $this->id();
            } else if (config('ecommerce.migration.primary') === 'ulid') {
                $this->ulid('id')->primary();
            } else if (config('ecommerce.migration.primary') === 'uuid') {
                $this->uuid('id')->primary();
            }
        });

        Blueprint::macro('ecommerceParent', function () {
            if(config('ecommerce.migration.primary') === 'id') {
                $this->unsignedBigInteger('parent_id')->nullable()->index();
            } else if (config('ecommerce.migration.primary') === 'ulid') {
                $this->ulid('parent_id')->nullable()->index();
            } else if (config('ecommerce.migration.primary') === 'uuid') {
                $this->uuid('parent_id')->nullable()->index();
            }
        });

        Blueprint::macro('ecommercePrimaries', function ($product, $category) {
            if(config('ecommerce.migration.primary') === 'id') {
                $this->unsignedBigInteger("{$product}_id");
                $this->unsignedBigInteger("{$category}_id");
            } else if (config('ecommerce.migration.primary') === 'ulid') {
                $this->ulid("{$product}_id");
                $this->ulid("{$category}_id");
            } else if (config('ecommerce.migration.primary') === 'uuid') {
                $this->uuid("{$product}_id");
                $this->uuid("{$category}_id");
            }

            $this->primary(["{$product}_id", "{$category}_id"], "{$product}_{$category}_primary");
            $this->index(["{$product}_id", "{$category}_id"], "{$product}_{$category}_index");
        });

        Blueprint::macro('ecommerceRelation', function ($name, $nullable = false, $foreign = false) {
            $singular = Str::singular(config("ecommerce.migration.{$name}_table.name"));
            if(config('ecommerce.migration.primary') === 'id') {
                $nullable ? $this->unsignedBigInteger("{$singular}_id")->nullable()->index() : $this->unsignedBigInteger("{$singular}_id")->index();
            } else if (config('ecommerce.migration.primary') === 'ulid') {
                $nullable ? $this->ulid("{$singular}_id")->nullable()->index() : $this->ulid("{$singular}_id")->index();
            } else if (config('ecommerce.migration.primary') === 'uuid') {
                $nullable ? $this->uuid("{$singular}_id")->nullable()->index() : $this->uuid("{$singular}_id")->index();
            }

            if($foreign) {
                $this->foreign("{$singular}_id")
                    ->references('id')
                    ->on(config("ecommerce.migration.{$name}_table.name"))
                    ->onDelete('cascade');
            }
        });
    }
}
