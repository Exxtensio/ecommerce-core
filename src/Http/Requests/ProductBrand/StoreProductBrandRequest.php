<?php

namespace Sambu\Ecommerce\Http\Requests\ProductBrand;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductBrandRequest extends FormRequest
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
        $table = app('ecommerce')::getProductBrandTable();
        return [
            'name' => ['required', 'string', 'max:255', "unique:$table,name"],
            'slug' => ['required', 'string', 'max:255', "unique:$table,slug"],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'src' => ['nullable', 'string', 'max:255'],
        ];
    }
}
