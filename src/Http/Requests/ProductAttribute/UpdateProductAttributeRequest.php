<?php

namespace Sambu\Ecommerce\Http\Requests\ProductAttribute;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductAttributeRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'key' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'key')
                    ->where('value', $this->get('value'))->ignore($id)
            ],
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique($table, 'value')
                    ->where('key', $this->get('key'))->ignore($id)
            ]
        ];
    }
}
