<?php

namespace Sambu\Ecommerce\Http\Controllers\Relations\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\Product;
use Sambu\Ecommerce\Resources\ProductResource;

class ProductImageApiController extends Controller
{
    public function store(Requests\ProductImage\StoreProductImageRequest $request, $id): JsonResponse
    {
        $data = Product::findOrFail($id);

        if($data->images()->withTrashed()->where('src', $request->get('src'))->exists()) {
            $data->images()
                ->withTrashed()
                ->where('src', $request->get('src'))
                ->restore();
            if($request->get('default')) {
                $data->images()
                    ->where('default', 1)
                    ->update(['default' => 0]);

                $data->images()
                    ->where('src', $request->get('src'))
                    ->update(['default' => $request->get('default')]);
            }
        } else if(!$data->images()->where('src', $request->get('src'))->exists()) {
            if($request->get('default'))
                $data->images()
                    ->where('default', 1)
                    ->update(['default' => 0]);

            $productId = app('ecommerce')::getProductId();
            $data->images()->create([
                'src' => $request->get('src'),
                $productId => $id,
                'default' => $request->get('default') ?? 0,
            ]);
        }

        return response()->json(
            new ProductResource($data)
        );
    }

    public function destroy(Requests\ProductImage\FindProductImageRequest $request, $id, $imageId): JsonResponse
    {
        $data = Product::findOrFail($id);
        $data->images()
            ->where('id', $imageId)
            ->delete();

        return response()->json(
            new ProductResource($data)
        );
    }
}
