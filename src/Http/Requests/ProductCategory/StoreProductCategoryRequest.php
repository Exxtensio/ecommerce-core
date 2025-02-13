<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductCategory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if(!$this->get('slug')) {
            $this->merge(['slug' => Str::slug($this->get('name'))]);
        }
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $table = app('ecommerce')::getProductCategoryTable();
        return [
            'name' => ['required', 'string', 'max:255', "unique:$table,name"],
            'slug' => ['required', 'string', 'max:255', "unique:$table,slug"],
            'parent_id' => ['nullable', "exists:$table,id"],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'src' => ['nullable', 'string', 'max:255'],
        ];
    }
}
