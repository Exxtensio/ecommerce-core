<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\ProductBrand;

class ProductBrandApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = ProductBrand::all();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductBrand\StoreProductAttributeRequest $request): JsonResponse
    {
        $data = ProductBrand::create($request->all());

        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $data = ProductBrand::findOrFail($id);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductBrand\UpdateProductAttributeRequest $request, $id): JsonResponse
    {
        $data = ProductBrand::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        ProductBrand::destroy($id);
        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id): JsonResponse
    {
        ProductBrand::withTrashed()->findOrFail($id)->restore();
        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete($id): JsonResponse
    {
        ProductBrand::forceDestroy($id);
        return response()->json();
    }
}
