<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;

class TokoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_toko' => $this->nama_toko,
            'products' => ProductResource::collection($this->products),
            'category' => new CategoryResource($this->category),
            'description' => $this->description,
            'icons' => $this->icons
        ];
    }
}
