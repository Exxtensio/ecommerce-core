<?php

namespace Sambu\Ecommerce\Http\Controllers\Relations\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\Product;

class ProductAttributeApiController extends Controller
{
    public function attach(Requests\Relations\Product\AttachProductAttributeRequest $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->attributes()->sync($request->get('relations'));

        return response()->json($data->load('attributes'));
    }

    public function detach(Requests\Relations\Product\DetachProductAttributeRequest $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->attributes()->detach($request->get('relations'));

        return response()->json($data->load('attributes'));
    }
}
