<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "product_id" => (int)$this->product_id,
            "shipping_method_id"=> (int)$this->shipping_method_id,
            "shipping_method" => $this->shippingMethod,
        ];
    }
}
