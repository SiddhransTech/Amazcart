<?php

namespace App\Http\Resources\Api\v1\Checkout;

use App\Http\Resources\CouponProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponReource extends JsonResource
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
            "title" => $this->title,
            "coupon_code" => $this->coupon_code,
            "coupon_type" => (int) $this->coupon_type,
            "start_date" =>$this->start_date,
            "end_date" => $this->end_date,
            "discount" => $this->discount,
            "discount_type" => (int) $this->discount_type,
            "minimum_shopping" => (double) $this->minimum_shopping,
            "maximum_discount" => (double) $this->maximum_discount,
            "created_by" =>$this->created_by,
            "updated_by" => $this->updated_by,
            "is_expire" => $this->is_expire,
            "is_multiple_buy" => (int) $this->is_multiple_buy,
            "multiple_buy_limit" => (int) $this->multiple_buy_limit,
            "created_at" =>$this->created_at,
            "updated_at" => $this->updated_at,
            "products" =>  CouponProductResource::collection($this->products)//$this->products
        ];
    }
}
