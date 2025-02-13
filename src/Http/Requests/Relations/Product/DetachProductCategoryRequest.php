<?php

namespace Exxtensio\EcommerceCore\Http\Requests\Relations\Product;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DetachProductCategoryRequest extends FormRequest
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
            'relations' => ['required', 'array', 'min:1']
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
