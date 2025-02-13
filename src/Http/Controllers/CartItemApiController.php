<?php

namespace Exxtensio\EcommerceCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Exxtensio\EcommerceCore\Http\Requests;
use Exxtensio\EcommerceCore\Models;
use Exxtensio\EcommerceCore\Resources;

class CartItemApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\CartItem\StoreCartItemRequest $request): JsonResponse
    {
        $data = Models\CartItem::firstOrCreate($request->all());
        $data = Models\CartItem::find($data->id);

        return response()->json(
            new Resources\CartItemResource($data),
            201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\CartItem\UpdateCartItemRequest $request, $id): JsonResponse
    {
        $data = Models\CartItem::findOrFail($id);
        $data->fill($request->only('quantity'))->save();

        return response()->json(
            new Resources\CartItemResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\CartItem\FindCartItemRequest $request, $id): JsonResponse
    {
        Models\CartItem::destroy($id);

        return response()->json();
    }
}
