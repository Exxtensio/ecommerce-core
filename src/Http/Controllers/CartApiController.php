<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models;
use Sambu\Ecommerce\Resources;

class CartApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\Cart\StoreCartRequest $request): JsonResponse
    {
        $request->request->remove('code');
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
    public function show($id): JsonResponse
    {
        $data = Models\Cart::findOrFail($id);

        return response()->json(
            new Resources\CartResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        Models\Cart::destroy($id);

        return response()->json();
    }
}
