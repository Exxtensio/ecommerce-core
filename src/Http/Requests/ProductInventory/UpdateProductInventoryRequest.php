<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductInventory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
            'code' => $this->get('country')
        ]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $productTable = app('ecommerce')::getProductTable();
        $countryTable = app('ecommerce')::getCountryTable();
        $pricePlace = config('ecommerce.migration.product_price_table.price_decimal_places');
        $stockPlace = config('ecommerce.migration.product_stock_table.stock_decimal_places');
        $defaultCountry = config('ecommerce.default.country');

        return [
            'id' => ['required', "exists:$productTable,id"],
            'country' => ['required', "not_in:$defaultCountry", "exists:$countryTable,code"],
            'code' => [
                Rule::exists($countryTable)
                    ->where(fn(Builder $query) => $query->where('active', 1)),
            ],
            'column' => ['required', 'in:price,stock'],
            'price' => ['required_if:column,price', "decimal:$pricePlace"],
            'stock' => ['required_if:column,stock', "decimal:$stockPlace"],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
        $this->query->remove('code');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\Product] {$this->get('id')}",
            'code.exists' => 'The selected country is invalid.'
        ];
    }
}
