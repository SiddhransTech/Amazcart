<?php

namespace App\Http\Resources\Api\v1\Profile;

use App\Http\Resources\Api\v1\Checkout\CouponReource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCouponResource extends JsonResource
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
            "customer_id"=> $this->customer_id,
            "coupon_id" => $this->coupon_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "coupon" => new CouponReource($this->coupon)
        ];
    }
}
