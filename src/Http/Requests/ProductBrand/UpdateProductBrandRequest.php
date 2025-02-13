<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductBrand;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductBrandRequest extends FormRequest
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
        $table = app('ecommerce')::getProductBrandTable();
        $id = $this->route('id');

        return [
            'id' => ['required', "exists:$table,id"],
            'name' => ['nullable', 'string', 'max:255', "unique:$table,name,$id"],
            'slug' => ['nullable', 'string', 'max:255', "unique:$table,slug,$id"],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'src' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\ProductBrand] {$this->get('id')}"
        ];
    }
}
