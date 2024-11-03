<?php

namespace Sambu\Ecommerce\Http\Requests\ProductInventory;

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
        $this->merge(['code' => $this->get('country')]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $countryTable = app('ecommerce')::getCountryTable();
        $pricePlace = config('ecommerce.migration.product_price_table.price_decimal_places');
        $stockPlace = config('ecommerce.migration.product_stock_table.stock_decimal_places');
        $defaultCountry = config('ecommerce.default.country');

        return [
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

    public function messages(): array
    {
        return [
            'code.exists' => 'The selected country is invalid.'
        ];
    }
}
