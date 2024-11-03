<?php

namespace Sambu\Ecommerce\Http\Requests\ProductImage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductImageRequest extends FormRequest
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
        $table = app('ecommerce')::getProductTable();
        return [
            'id' => ['required', "exists:$table,id"],
            'default' => ['nullable', 'boolean'],
            'src' => ['required', 'string', 'max:255'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Sambu\\Ecommerce\\Models\\Product\\Product] {$this->get('id')}"
        ];
    }
}
