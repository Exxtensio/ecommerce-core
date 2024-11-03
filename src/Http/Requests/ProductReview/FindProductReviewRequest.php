<?php

namespace Sambu\Ecommerce\Http\Requests\ProductReview;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FindProductReviewRequest extends FormRequest
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
        $table = app('ecommerce')::getProductReviewTable();
        return [
            'id' => ['required', "exists:$table,id"]
        ];
    }

    protected function passedValidation(): void
    {
        $this->query->remove('id');
    }

    public function messages(): array
    {
        return [
            'id.exists' => "No query results for model [Sambu\\Ecommerce\\Models\\Product\\ProductReview] {$this->get('id')}"
        ];
    }
}
