<?php

namespace Exxtensio\EcommerceCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exxtensio\EcommerceCore\Http\Requests;
use Exxtensio\EcommerceCore\Models;
use Exxtensio\EcommerceCore\Resources;

class ProductCategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Models\Product\ProductCategory::all();

        return response()->json(
            Resources\ProductCategoryResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductCategory\StoreProductCategoryRequest $request): JsonResponse
    {
        $data = Models\Product\ProductCategory::create($request->all());
        $data = Models\Product\ProductCategory::find($data->id);

        return response()->json(
            new Resources\ProductCategoryResource($data),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Requests\ProductCategory\FindProductCategoryRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductCategory::findOrFail($id);

        return response()->json(
            new Resources\ProductCategoryResource($data)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductCategory\UpdateProductCategoryRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductCategory::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new Resources\ProductCategoryResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\ProductCategory\FindProductCategoryRequest $request, $id): JsonResponse
    {
        Models\Product\ProductCategory::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Requests\ProductCategory\FindProductCategoryRequest $request, $id): JsonResponse
    {
        Models\Product\ProductCategory::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete(Requests\ProductCategory\FindProductCategoryRequest $request, $id): JsonResponse
    {
        Models\Product\ProductCategory::forceDestroy($id);

        return response()->json();
    }
}
