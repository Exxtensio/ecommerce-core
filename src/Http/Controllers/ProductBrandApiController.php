<?php

namespace Exxtensio\EcommerceCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exxtensio\EcommerceCore\Http\Requests;
use Exxtensio\EcommerceCore\Models;
use Exxtensio\EcommerceCore\Resources;

class ProductBrandApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Models\Product\ProductBrand::all();

        return response()->json(
            Resources\ProductBrandResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductBrand\StoreProductBrandRequest $request): JsonResponse
    {
        $data = Models\Product\ProductBrand::create($request->all());
        $data = Models\Product\ProductBrand::find($data->id);

        return response()->json(
            new Resources\ProductBrandResource($data),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Requests\ProductBrand\FindProductBrandRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductBrand::findOrFail($id);

        return response()->json(
            new Resources\ProductBrandResource($data)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductBrand\UpdateProductBrandRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductBrand::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new Resources\ProductBrandResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\ProductBrand\FindProductBrandRequest $request, $id): JsonResponse
    {
        Models\Product\ProductBrand::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Requests\ProductBrand\FindProductBrandRequest $request, $id): JsonResponse
    {
        Models\Product\ProductBrand::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete(Requests\ProductBrand\FindProductBrandRequest $request, $id): JsonResponse
    {
        Models\Product\ProductBrand::forceDestroy($id);

        return response()->json();
    }
}
