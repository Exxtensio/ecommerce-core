<?php

namespace Exxtensio\EcommerceCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Exxtensio\EcommerceCore\Http\Requests;
use Exxtensio\EcommerceCore\Models;
use Exxtensio\EcommerceCore\Resources;

class CartApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\Cart\StoreCartRequest $request): JsonResponse
    {
        $data = Models\Cart::firstOrCreate($request->all());
        $data = Models\Cart::find($data->id);

        return response()->json(
            new Resources\CartResource($data),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Requests\Cart\FindCartRequest $request, $id): JsonResponse
    {
        $data = Models\Cart::findOrFail($id);

        return response()->json(
            new Resources\CartResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\Cart\FindCartRequest $request, $id): JsonResponse
    {
        Models\Cart::destroy($id);

        return response()->json();
    }
}
