<?php

namespace Sambu\Ecommerce\Http\Controllers\Relations\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Sambu\Ecommerce\Http\Requests;
use Sambu\Ecommerce\Models\Product\Product;

class ProductCategoryApiController extends Controller
{
    public function attach(Request $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->categories()->sync($request->get('relations'));

        return response()->json($data->load('categories'));
    }

    public function detach(Request $request): JsonResponse
    {
        $data = Product::findOrFail($request->route('id'));
        $data->categories()->detach($request->get('relations'));

        return response()->json($data->load('categories'));
    }
}
