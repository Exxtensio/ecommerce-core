<?php

namespace Exxtensio\EcommerceCore\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductBrandResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'src' => $this->src,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
