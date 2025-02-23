<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PickupInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $city = null;
        if(!empty($this->city))
        {
            $city['id'] = $this->city->id;
            $city['name'] = $this->city->name;
        }

        $state = null;
        if(!empty($this->state))
        {
            $state['id'] = $this->state->id;
            $state['name'] = $this->state->name;
        }

        $country = null;
        if(!empty($this->country))
        {
            $country['id'] = $this->country->id;
            $country['name'] = $this->country->name;
        }
        return [
            "id"=> $this->id,
            "pickup_location" => $this->pickup_location,
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "address_2" => $this->address_2,
            "city_id" => $this->city_id,
            "state_id" => $this->state_id,
            "country_id" => $this->country_id,
            "pin_code" => $this->pin_code,
            "lat" => $this->lat,
            "long" => $this->long,
            "status" => $this->status,
            "is_default" => $this->is_default,
            "is_set" => $this->is_set,
            "city" => $city,
            "state" => $state,
            "country" => $country,
        ];
    }
}
