<?php

namespace Exxtensio\EcommerceCore\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exxtensio\EcommerceCore\Http\Requests;
use Exxtensio\EcommerceCore\Models;
use Exxtensio\EcommerceCore\Resources;

class ProductAttributeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $data = Models\Product\ProductAttribute::all();

        return response()->json(
            Resources\ProductAttributeResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductAttribute\StoreProductAttributeRequest $request): JsonResponse
    {
        $data = Models\Product\ProductAttribute::create($request->all());
        $data = Models\Product\ProductAttribute::find($data->id);

        return response()->json(
            new Resources\ProductAttributeResource($data),
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Requests\ProductAttribute\FindProductAttributeRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductAttribute::findOrFail($id);

        return response()->json(
            new Resources\ProductAttributeResource($data)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductAttribute\UpdateProductAttributeRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductAttribute::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new Resources\ProductAttributeResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\ProductAttribute\FindProductAttributeRequest $request, $id): JsonResponse
    {
        Models\Product\ProductAttribute::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Requests\ProductAttribute\FindProductAttributeRequest $request, $id): JsonResponse
    {
        Models\Product\ProductAttribute::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete(Requests\ProductAttribute\FindProductAttributeRequest $request, $id): JsonResponse
    {
        Models\Product\ProductAttribute::forceDestroy($id);

        return response()->json();
    }
}
