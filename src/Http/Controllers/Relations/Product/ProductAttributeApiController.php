<?php

namespace Exxtensio\EcommerceCore\Http\Controllers\Relations\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Exxtensio\EcommerceCore\Http\Requests;
use Exxtensio\EcommerceCore\Models\Product\Product;
use Exxtensio\EcommerceCore\Resources\ProductResource;

class ProductAttributeApiController extends Controller
{
    public function attach(Requests\Relations\Product\AttachProductAttributeRequest $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->attributes()->sync($request->get('relations'));

        return response()->json(
            new ProductResource($data)
        );
    }

    public function detach(Requests\Relations\Product\DetachProductAttributeRequest $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->attributes()->detach($request->get('relations'));

        return response()->json(
            new ProductResource($data)
        );
    }
}
