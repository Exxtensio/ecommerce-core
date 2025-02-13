<?php

namespace Exxtensio\EcommerceCore\Http\Requests\ProductReview;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductReviewRequest extends FormRequest
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
        $productTable = app('ecommerce')::getProductTable();
        $productId = app('ecommerce')::getProductId();
        return [
            'user_id' => ['required', "exists:users,id"],
            $productId => ['required', "exists:$productTable,id"],
            'rating' => ['required', 'in:1,2,3,4,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }
}
