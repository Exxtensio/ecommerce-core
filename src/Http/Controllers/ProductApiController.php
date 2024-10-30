<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\Product;
use Sambu\Ecommerce\Resources\ProductResource;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Product::all();

        return response()->json(
            ProductResource::collection($data->load([
                'prices',
                'stocks',
                'images',
                'brand',
                'categories',
                'attributes'
            ]))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\Product\StoreProductRequest $request): JsonResponse
    {
        $data = Product::create($request->all());

        return response()->json(
            new ProductResource($data->load([
                'prices',
                'stocks',
                'images',
                'brand',
                'categories',
                'attributes'
            ])),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data = Product::findOrFail($id);

        return response()->json(
            new ProductResource($data)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\Product\UpdateProductRequest $request, $id): JsonResponse
    {
        $data = Product::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new ProductResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        Product::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id): JsonResponse
    {
        Product::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete($id): JsonResponse
    {
        Product::forceDestroy($id);

        return response()->json();
    }
}
