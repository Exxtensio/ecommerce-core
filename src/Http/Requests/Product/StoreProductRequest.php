<?php

namespace Sambu\Ecommerce\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Sambu\Ecommerce\Models\Product\Product;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if(!$this->get('slug')) {
            $this->merge(['slug' => Str::slug($this->get('name'))]);
        }

        if(!$this->get('type')) {
            $this->merge(['type' => Product::DEFAULT_TYPE]);
        }

        if(!$this->get('unit')) {
            $this->merge(['unit' => match ($this->get('type')) {
                Product::TYPE_QUANTITY => Product::DEFAULT_QUANTITY_UNIT,
                Product::TYPE_DIGITAL => Product::DEFAULT_DIGITAL_UNIT,
                Product::TYPE_WEIGHT => Product::DEFAULT_WEIGHT_UNIT,
                Product::TYPE_VOLUME => Product::DEFAULT_VOLUME_UNIT,
                Product::TYPE_LENGTH => Product::DEFAULT_LENGTH_UNIT,
                default => null
            }]);
        }

        if(!$this->get('stock')) {
            $this->merge(['stock' => number_format(0, config('ecommerce.migration.product_stock_table.stock_decimal_places'), '.', '')]);
        }
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $table = app('ecommerce')::getProductTable();
        $brandTable = app('ecommerce')::getProductBrandTable();
        $productBrandId = app('ecommerce')::getProductBrandId();
        $pricePlace = config('ecommerce.migration.product_price_table.price_decimal_places');
        $stockPlace = config('ecommerce.migration.product_stock_table.stock_decimal_places');
        return [
            $productBrandId => ['nullable',"exists:$brandTable,id"],
            'type' => ['nullable', 'in:dig,qty,wt,vol,len'],
            'unit' => ['nullable', $this->getUnitInRules()],
            'step' => ['nullable', "decimal:$stockPlace"],
            'name' => ['required', 'string', 'max:255', "unique:$table,name"],
            'slug' => ['required', 'string', 'max:255', "unique:$table,slug"],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:255'],
            'price' => ['required', "decimal:$pricePlace"],
            'stock' => ['nullable', "decimal:$stockPlace"],
            'image' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function getUnitInRules(): string
    {
        $rules = match ($this->get('type')) {
            Product::TYPE_QUANTITY => implode(',', Product::QUANTITY_UNITS),
            Product::TYPE_DIGITAL => implode(',', Product::DIGITAL_UNITS),
            Product::TYPE_WEIGHT => implode(',', Product::WEIGHT_UNITS),
            Product::TYPE_VOLUME => implode(',', Product::VOLUME_UNITS),
            Product::TYPE_LENGTH => implode(',', Product::LENGTH_UNITS),
            default => ''
        };

        return "in:$rules";
    }
}
