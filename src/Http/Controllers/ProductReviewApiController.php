<?php

namespace Sambu\Ecommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models;
use Sambu\Ecommerce\Resources;

class ProductReviewApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Requests\ProductReview\StoreProductReviewRequest $request): JsonResponse
    {
        $data = Models\Product\ProductReview::create($request->all());
        $data = Models\Product\ProductReview::find($data->id);

        return response()->json(
            new Resources\ProductReviewResource($data),
            201
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Requests\ProductReview\UpdateProductReviewRequest $request, $id): JsonResponse
    {
        $data = Models\Product\ProductReview::findOrFail($id);
        $data->fill($request->all())->save();

        return response()->json(
            new Resources\ProductReviewResource($data)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests\ProductReview\FindProductReviewRequest $request, $id): JsonResponse
    {
        Models\Product\ProductReview::destroy($id);

        return response()->json();
    }

    /**
     * Restore the specified resource.
     */
    public function restore(Requests\ProductReview\FindProductReviewRequest $request, $id): JsonResponse
    {
        Models\Product\ProductReview::withTrashed()
            ->findOrFail($id)
            ->restore();

        return response()->json();
    }

    /**
     * Completely remove the specified resource from storage.
     */
    public function forceDelete(Requests\ProductReview\FindProductReviewRequest $request, $id): JsonResponse
    {
        Models\Product\ProductReview::forceDestroy($id);

        return response()->json();
    }
}
