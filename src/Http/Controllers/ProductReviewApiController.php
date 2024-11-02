<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\ProductReview;
use Sambu\Ecommerce\Resources\ProductReviewResource;

class ProductReviewApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductReview\StoreProductReviewRequest $request): JsonResponse
    {
        $data = ProductReview::create($request->all());

        return response()->json(
            new ProductReviewResource($data),
            201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductReview\UpdateProductReviewRequest $request, $id): JsonResponse
    {
        $data = ProductReview::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new ProductReviewResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        ProductReview::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore($id): JsonResponse
    {
        ProductReview::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete($id): JsonResponse
    {
        ProductReview::forceDestroy($id);

        return response()->json();
    }
}
