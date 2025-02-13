<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductImage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['country' => $this->route('country')]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $countryTable = app('ecommerce')::getCountryTable();
        $defaultCountry = config('ecommerce.default.country');

        return [
            'country' => ['required', "not_in:$defaultCountry", "exists:$countryTable,code"],
        ];
    }
}
