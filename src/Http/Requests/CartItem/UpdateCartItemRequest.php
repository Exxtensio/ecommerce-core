<?php

namespace Exxtensio\EcommerceCore\Http\Requests\CartItem;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Exxtensio\EcommerceCore\Models\CartItem;

class UpdateCartItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $cartItem = CartItem::find($this->route('id'));
        $this->merge(['id' => $this->route('id')]);
        $this->merge(['cart_id' => $cartItem->cart->id ?? null]);
        $this->merge(['product_id' => $cartItem->product_id ?? null]);
        $this->merge(['country' => $cartItem->cart->country ?? null]);
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $table = app('ecommerce')::getCartItemTable();
        $cartTable = app('ecommerce')::getCartTable();
        $productTable = app('ecommerce')::getProductTable();
        $productStockTable = app('ecommerce')::getProductStockTable();
        $stockPlace = config('ecommerce.migration.product_stock_table.stock_decimal_places');

        $productId = app('ecommerce')::getProductId();
        $cartId = app('ecommerce')::getCartId();

        return [
            'id' => ['required', "exists:$table,id"],
            $cartId => ['required', "exists:$cartTable,id"],
            'quantity' => ['required', "decimal:$stockPlace"],
            $productId => [
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

    protected function passedValidation(): void
    {
        $this->query->remove('id');
        $this->query->remove('country');
    }

    public function messages(): array
    {
        $productId = app('ecommerce')::getProductId();
        return [
            'id.exists' => "No query results for model [Exxtensio\\EcommerceCore\\Models\\CartItem] {$this->get('id')}",
            "$productId.exists" => 'The selected product was not found in this quantity.'
        ];
    }
}
