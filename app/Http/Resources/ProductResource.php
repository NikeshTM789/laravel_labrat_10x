<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $featured_image = $this->getFirstMediaUrl('featured','thumbnail');

        return [
            'id'     => $this->id,
            'name'     => $this->name,
            'slug'     => $this->slug,
            'qty'      => $this->quantity,
            'price'    => $this->price,
            'discount' => $this->discount,
            'image'    => empty($featured_image) ? asset('assets/img/no-image.png') : $featured_image,
        ];
    }
}
