<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models;

class OrderApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\Order\StoreOrderRequest $request): JsonResponse
    {
        $orderId = DB::transaction(function () use ($request) {
            $cart = Models\Cart::find($request->get('cart_id'));

            $order = Models\Order::create([
                'user_id' => $cart->user_id,
                'country' => $cart->country,
                'amount' => $cart->items->sum(fn($item) => $item->product->prices->firstWhere('country', $cart->country)->price)
            ]);

            $productId = app('ecommerce')::getProductId();
            $orderId = app('ecommerce')::getOrderId();
            $cart->items->each(function ($item) use ($productId, $orderId, $cart, $order) {
                Models\OrderItem::create([
                    $orderId => $order->id,
                    $productId => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->prices->firstWhere('country', $cart->country)->price,
                ]);
            });

            $cart->delete();
            return $order->id;
        });

        $data = Models\Order::findOrFail($orderId);

        return response()->json(
            $data,
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\Order\FindOrderRequest $request, $id): JsonResponse
    {
        Models\Order::destroy($id);

        return response()->json();
    }
}
