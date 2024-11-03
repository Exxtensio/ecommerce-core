<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models;
use Sambu\Ecommerce\Resources;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Models\Product\Product::all();

        return response()->json(
            Resources\ProductResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\Product\StoreProductRequest $request): JsonResponse
    {
        $data = Models\Product\Product::create($request->all());
        $data = Models\Product\Product::find($data->id);

        return response()->json(
            new Resources\ProductResource($data),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Requests\Product\FindProductRequest $request, $id): JsonResponse
    {
        $data = Models\Product\Product::findOrFail($id);

        return response()->json(
            new Resources\ProductResource($data)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\Product\UpdateProductRequest $request, $id): JsonResponse
    {
        $data = Models\Product\Product::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new Resources\ProductResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\Product\FindProductRequest $request, $id): JsonResponse
    {
        Models\Product\Product::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Requests\Product\FindProductRequest $request, $id): JsonResponse
    {
        Models\Product\Product::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete(Requests\Product\FindProductRequest $request, $id): JsonResponse
    {
        Models\Product\Product::forceDestroy($id);

        return response()->json();
    }
}
