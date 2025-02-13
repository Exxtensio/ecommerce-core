<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductImage;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FindProductImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
            'imageId' => $this->route('imageId'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $table = app('ecommerce')::getProductTable();
        $imageTable = app('ecommerce')::getProductImageTable();
        return [
            'id' => ['required', "exists:$table,id"],
            'imageId' => ['required', "exists:$imageTable,id"],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
        $this->query->remove('imageId');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\Product] {$this->get('id')}",
            'imageId.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\ProductImage] {$this->get('imageId')}",
        ];
    }
}
