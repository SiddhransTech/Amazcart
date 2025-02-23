<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Setup\Transformers\CityResource;
use Modules\Setup\Transformers\CountryResource;
use Modules\Setup\Transformers\StateResource;

class OrderAddressResource extends JsonResource
{

    public function toArray(Request $request)
    {

        return [
            "id" => $this->id,
            "order_id" => $this->order_id,
            "customer_id" => $this->customer_id,
            "shipping_name" => $this->shipping_name,
            "shipping_email" => $this->shipping_email,
            "shipping_phone" => $this->shipping_phone,
            "shipping_address" => $this->shipping_address,
            "shipping_country_id" => $this->shipping_country_id,
            "shipping_state_id" => $this->shipping_state_id,
            "shipping_city_id" => $this->shipping_city_id,
            "shipping_postcode" => $this->shipping_postcode,
            "bill_to_same_address" => $this->bill_to_same_address,
            "billing_name" => $this->billing_name,
            "billing_email" => $this->billing_email,
            "billing_phone" => $this->billing_phone,
            "billing_address" => $this->billing_address,
            "billing_country_id"=> $this->billing_country_id,
            "billing_state_id" => $this->billing_state_id,
            "billing_city_id" => $this->billing_city_id,
            "billing_postcode" => $this->billing_postcode,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "get_shipping_country" => new CountryResource($this->getShippingCountry),
            "get_shipping_state" => new StateResource($this->getShippingState),
            "get_shipping_city" => new CityResource($this->getShippingCity),
        ];

    }

}
