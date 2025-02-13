<?php

namespace Exxtensio\EcommerceCore\Http\Requests\Order;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        $cartTable = app('ecommerce')::getCartTable();
        $cartId = app('ecommerce')::getCartId();

        return [
            $cartId => ['required', "exists:$cartTable,id", new CheckCartItemQuantity()]
        ];
    }
}
