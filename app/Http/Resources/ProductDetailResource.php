<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ReviewResource;


class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'images' => $this->images,
            'price' => $this->price,
            'sold' => $this->sold,
            'stock' => $this->stock,
            'rating' => $this->rating,
            'location' => $this->location,
            'desc' => $this->description,
            'category' => $this->category,
            'toko' => $this->toko,
            'reviews' => ReviewResource::collection($this->reviews),
            'pakets' => $this->pakets
        ];
    }
}
