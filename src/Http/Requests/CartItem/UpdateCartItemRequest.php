<?php

namespace Sambu\Ecommerce\Http\Requests\CartItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Sambu\Ecommerce\Models\CartItem;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $cartItem = CartItem::find($this->route('id'));
        $this->merge(['cart_id' => $cartItem->cart->id]);
        $this->merge(['product_id' => $cartItem->product_id]);
        $this->merge(['country' => $cartItem->cart->country]);
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

        return [
            'cart_id' => ['required', "exists:$cartTable,id"],
            'quantity' => ['required', "decimal:$stockPlace"],
            'product_id' => [
                'required',
                "exists:$productTable,id",
                Rule::exists($productStockTable)
                    ->where(function (Builder $query) {
                        return $query
                            ->where('country', $this->get('country'))
                            ->where('stock', '>=', $this->get('quantity'));
                    }),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            "product_id.exists" => 'The selected product was not found in this quantity.'
        ];
    }
}
