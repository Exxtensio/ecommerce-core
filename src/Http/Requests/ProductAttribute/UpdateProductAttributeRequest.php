<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductAttribute;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $table = app('ecommerce')::getProductAttributeTable();
        $id = $this->route('id');

        return [
            'id' => ['required', "exists:$table,id"],
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

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\ProductAttribute] {$this->get('id')}"
        ];
    }
}
