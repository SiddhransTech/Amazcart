<?php

namespace App\Http\Resources\Api\v1\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Setup\Transformers\CountryResource;
use Modules\Setup\Transformers\StateResource;

class CustomerAddressResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "name" => $this->name,
            "email" =>$this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "country" => $this->country,
            "postal_code" => $this->postal_code,
            "is_shipping_default" => $this->is_shipping_default,
            "is_billing_default" => $this->is_billing_default,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "get_country" => !empty($this->getCountry) ? new CountryResource($this->getCountry):null,
            "get_state" => !empty($this->getState) ? new StateResource($this->getState):null,
            "get_city" => !empty($this->getCity) ? new CountryResource($this->getCity):null,
        ];
    }

}
