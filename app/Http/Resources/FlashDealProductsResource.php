<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\v1\AllProductsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlashDealProductsResource extends JsonResource
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
            "flash_deal_id" => $this->flash_deal_id,
            "seller_product_id" => $this->seller_product_id,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "product" => new AllProductsResource($this->product),
        ];
    }
}
