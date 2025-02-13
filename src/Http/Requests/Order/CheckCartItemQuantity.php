<?php

namespace Exxtensio\EcommerceCore\Http\Requests\Order;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Exxtensio\EcommerceCore\Models\Cart;
use Exxtensio\EcommerceCore\Models\CartItem;

class CheckCartItemQuantity implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productId = app('ecommerce')::getProductId();

        $cart = Cart::find($value);
        $cart->items->each(function (CartItem $item) use ($productId, $cart, $fail) {
            $currentStock = $item->product->stocks->where('country', $cart->country)->first()->stock ?? 0;
            if($currentStock < $item->quantity) {
                $fail("The model [Exxtensio\\EcommerceCore\\Models\\Product\\Product] $item[$productId] was not found in this quantity.");
            }
        });
    }
}
