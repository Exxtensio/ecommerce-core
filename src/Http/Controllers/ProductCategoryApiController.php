<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\ProductCategory;

class ProductCategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = ProductCategory::all();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductCategory\StoreProductCategoryRequest $request): JsonResponse
    {
        $data = ProductCategory::create($request->all());

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data = ProductCategory::findOrFail($id);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductCategory\UpdateProductCategoryRequest $request, $id): JsonResponse
    {
        $data = ProductCategory::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        ProductCategory::destroy($id);
        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id): JsonResponse
    {
        ProductCategory::withTrashed()->findOrFail($id)->restore();
        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete($id): JsonResponse
    {
        ProductCategory::forceDestroy($id);
        return response()->json();
    }
}
