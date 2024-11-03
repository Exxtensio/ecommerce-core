<?php

namespace Sambu\Ecommerce\Http\Requests\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Sambu\Ecommerce\Models\Product\Product;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
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
        $id = $this->route('id');

        return [
            $productBrandId => ['nullable',"exists:$brandTable,id"],
            'type' => ['nullable', 'in:dig,qty,wt,vol,len'],
            'unit' => ['sometimes', 'required_with:type', $this->getUnitInRules()],
            'step' => ['nullable', "decimal:$stockPlace"],
            'name' => ['nullable', 'string', 'max:255', "unique:$table,name,$id"],
            'slug' => ['nullable', 'string', 'max:255', "unique:$table,slug,$id"],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', "decimal:$pricePlace"],
            'stock' => ['nullable', "decimal:$stockPlace"],
            'image' => ['nullable', 'string', 'max:255']
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
