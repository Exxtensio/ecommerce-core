<?php

namespace Sambu\Ecommerce\Http\Requests\ProductBrand;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductBrandRequest extends FormRequest
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
        $table = app('ecommerce')::getProductCategoryTable();
        $id = $this->route('id');

        return [
            'name' => ['nullable', 'string', 'max:255', "unique:$table,name,$id"],
            'slug' => ['nullable', 'string', 'max:255', "unique:$table,slug,$id"],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'src' => ['nullable', 'string', 'max:255'],
        ];
    }
}
