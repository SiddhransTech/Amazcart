<?php

namespace App\Http\Resources;

use App\Http\Resources\Api\v1\Cart\CartProductListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shipping_method = null;
        if (!empty($this->shippingMethod)) {
            $shipping_method = $this->shippingMethod;
            // $shipping_method = [
            //     'id'=> (int)$shippingMethod->id,
            //     'method_name'=> (string)$shippingMethod->method_name,
            //     'logo'=> (string)$shippingMethod->logo,
            //     'phone'=> (string)$shippingMethod->phone,
            //     'shipment_time'=> (string)$shippingMethod->shipment_time,
            //     'cost'=> (float)$shippingMethod->cost,
            //     'is_active'=> (int)$shippingMethod->is_active,
            //     'created_at'=> (string)$shippingMethod->created_at,
            //     'updated_at'=> (string)$shippingMethod->updated_at,
            // ];
        }
        $saller = '';
        if (!empty($this->seller)) {
            $saller = $this->seller;
        }

        $customer = null;
        if (!empty($this->customer)) {
            $ctmr = $this->customer;
            $customer = [
                'id' => (int) $ctmr->id,
                'first_name' => (string) $ctmr->first_name,
                'last_name' => (string) $ctmr->last_name,
                'email' => (string) $ctmr->email,
                'email_verified_at' => (string) $ctmr->email_verified_at
            ];
        }

        $giftCard = null;
        if (!empty($this->giftCard)) {
            $giftCard = $this->giftCard;
        }

        $product = null;
        if (!empty($this->product)) {
            $product = $this->product;
        }

        return [
            'id' => (int) $this->id,
            'user_id' => (int) $this->user_id,
            'seller_id' => (int) $this->seller_id,
            'product_type' => (string) $this->product_type,
            'product_id' => (int) $this->product_id,
            'qty' => (int) $this->qty,
            'price' => (float) $this->price,
            'total_price' => (float) $this->total_price,
            'sku' => (string) $this->sku,
            'is_select' => (int) $this->is_select,
            'shipping_method_id' => (int) $this->shipping_method_id,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'shipping_method' => $shipping_method,
            'seller' => $saller,
            'customer' => $customer,
            'gift_card' => $giftCard,
            'product' => new CartProductListResource($product),
        ];
    }
}
