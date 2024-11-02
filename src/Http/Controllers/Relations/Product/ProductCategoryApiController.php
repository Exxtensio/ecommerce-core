<?php

namespace Sambu\Ecommerce\Http\Controllers\Relations\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\Product;
use Sambu\Ecommerce\Resources\ProductResource;

class ProductCategoryApiController extends Controller
{
    public function attach(Requests\Relations\Product\AttachProductCategoryRequest $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->categories()->sync($request->get('relations'));

        return response()->json(
            new ProductResource($data)
        );
    }

    public function detach(Requests\Relations\Product\DetachProductCategoryRequest $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->categories()->detach($request->get('relations'));

        return response()->json(
            new ProductResource($data)
        );
    }
}
