<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductReview;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $reviewTable = app('ecommerce')::getProductReviewTable();
        return [
            'id' => ['required', "exists:$reviewTable,id"],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\Product\\ProductReview] {$this->get('id')}"
        ];
    }
}
