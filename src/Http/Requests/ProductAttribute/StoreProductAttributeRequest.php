<?php

namespace Sambu\Ecommerce\Http\Requests\ProductAttribute;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $table = app('ecommerce')::getProductAttributeTable();
        return [
            'key' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'key')
                    ->where('value', $this->get('value'))
            ],
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'value')
                    ->where('key', $this->get('key'))
            ]
        ];
    }
}
