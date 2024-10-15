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
        $name = $this->name;
        // $name = (strlen($name) > 40) ? substr($name, 0, 30).'...' : $name;

        $details = $this->details;
        // $details = (strlen($details) > 200) ? substr($details, 0, 200).'...' : $details;
        $data = [
            'uuid'     => $this->uuid,
            'name'     => $name,
            'slug'     => $this->slug,
            'qty'      => $this->quantity,
            'price'    => $this->price,
            'discount' => $this->discount,
            'image'    => empty($featured_image) ? asset('assets/img/default-product.png') : $featured_image,
            'description' =>  $details
        ];
            $data['gallery'] = $this->getMedia('gallery')->map(fn($img) => $img->getUrl());
        if ($request->query('product')) {
        }
        return $data;
    }
}
