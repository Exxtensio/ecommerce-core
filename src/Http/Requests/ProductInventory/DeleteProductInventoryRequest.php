<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductInventory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProductInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $productTable = app('ecommerce')::getProductTable();
        $countryTable = app('ecommerce')::getCountryTable();
        $defaultCountry = config('ecommerce.default.country');

        return [
            'id' => ['required', "exists:$productTable,id"],
            'country' => ['required', "not_in:$defaultCountry", "exists:$countryTable,code"],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\Product] {$this->get('id')}"
        ];
    }
}
