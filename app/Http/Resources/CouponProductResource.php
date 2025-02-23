<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponProductResource extends JsonResource
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
               "coupon_id" => $this->coupon_id,
               "coupon_code" => $this->coupon_code,
               "product_id" => $this->product_id,
               "created_at" => $this->created_at,
               "updated_at" => $this->updated_at,
               "product" =>   new \App\Http\Resources\Api\v1\AllProductsResource($this->product),
        ];
    }
}
