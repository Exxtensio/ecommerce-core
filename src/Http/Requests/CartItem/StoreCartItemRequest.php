<?php

namespace Sambu\Ecommerce\Http\Requests\CartItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Sambu\Ecommerce\Models\Cart;

class StoreCartItemRequest extends FormRequest
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
        $productTable = app('ecommerce')::getProductTable();
        $productStockTable = app('ecommerce')::getProductStockTable();
        $stockPlace = config('ecommerce.migration.product_stock_table.stock_decimal_places');

        $productId = app('ecommerce')::getProductId();
        $cartId = app('ecommerce')::getCartId();

        return [
            $cartId => ['required', "exists:$cartTable,id"],
            'quantity' => ['required', "decimal:$stockPlace"],
            $productId => [
                'required',
                "exists:$productTable,id",
                Rule::exists($productStockTable)
                    ->where(function (Builder $query) use ($cartId) {
                        $cart = Cart::find($this->get($cartId));
                        return $query
                            ->where('country', $cart->country)
                            ->where('stock', '>=', $this->get('quantity'));
                    }),
            ]
        ];
    }

    public function messages(): array
    {
        $productId = app('ecommerce')::getProductId();
        return [
            "$productId.exists" => 'The selected product was not found in this quantity.'
        ];
    }
}
