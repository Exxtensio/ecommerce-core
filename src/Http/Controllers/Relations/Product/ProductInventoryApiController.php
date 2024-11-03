<?php

namespace Sambu\Ecommerce\Http\Controllers\Relations\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\Product;
use Sambu\Ecommerce\Resources\ProductResource;

class ProductInventoryApiController extends Controller
{
    public function store(Requests\ProductInventory\StoreProductInventoryRequest $request, $id): JsonResponse
    {
        $data = Product::findOrFail($id);

        if($data->prices()->withTrashed()->where('country', $request->get('country'))->exists()) {
            $data->prices()->withTrashed()->where('country', $request->get('country'))->restore();
        } else if(!$data->prices()->where('country', $request->get('country'))->exists()) {
            $data->prices()->create([
                'price' => $request->get('price'),
                'product_id' => $id,
                'country' => $request->get('country')
            ]);
        }

        if($data->stocks()->withTrashed()->where('country', $request->get('country'))->exists()) {
            $data->stocks()->withTrashed()->where('country', $request->get('country'))->restore();
        } else if(!$data->stocks()->where('country', $request->get('country'))->exists()) {
            $productId = app('ecommerce')::getProductId();
            $data->stocks()->create([
                'stock' => $request->get('stock'),
                $productId => $id,
                'country' => $request->get('country')
            ]);
        }

        return response()->json(
            new ProductResource($data)
        );
    }

    public function update(Requests\ProductInventory\UpdateProductInventoryRequest $request, $id): JsonResponse
    {
        $data = Product::findOrFail($id);

        if($request->get('column') === 'price') {
            $data->prices()
                ->where('country', $request->get('country'))
                ->update(['price' => $request->get('price')]);
        }

        if($request->get('column') === 'stock') {
            $data->stocks()
                ->where('country', $request->get('country'))
                ->update(['stock' => $request->get('stock')]);
        }

        return response()->json(
            new ProductResource($data)
        );
    }

    public function destroy(Requests\ProductInventory\DeleteProductInventoryRequest $request, $id): JsonResponse
    {
        $data = Product::findOrFail($id);

        $data->prices()->where('country', $request->get('country'))->delete();
        $data->stocks()->where('country', $request->get('country'))->delete();

        return response()->json(
            new ProductResource($data)
        );
    }
}
