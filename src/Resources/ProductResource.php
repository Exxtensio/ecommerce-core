<?php

namespace Sambu\Ecommerce\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Sambu\Ecommerce\Models\Product\Product;

class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $images = $this->whenLoaded('images');
        $prices = $this->whenLoaded('prices');
        $stocks = $this->whenLoaded('stocks');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $images->where('default', 1)->first()->src ?? null,
            'price' => $prices->where('country', 'US')->first()->price ?? 0,
            'stock' => $stocks->where('country', 'US')->first()->stock ?? 0,
            'type' => [
                'acronym' => $this->type,
                'value' => Product::ACRONYM[$this->type],
            ],
            'unit' => [
                'acronym' => $this->unit,
                'value' => Product::ACRONYM[$this->unit],
            ],
            'step' => $this->step,
            'images' => ProductImageResource::collection($images),
            'prices' => ProductPriceResource::collection($prices),
            'stocks' => ProductStockResource::collection($stocks),

            'brand' => new ProductBrandResource($this->whenLoaded('brand')),
            'categories' => ProductCategoryResource::collection($this->whenLoaded('categories')),
            'attributes' => ProductAttributeResource::collection($this->whenLoaded('attributes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
