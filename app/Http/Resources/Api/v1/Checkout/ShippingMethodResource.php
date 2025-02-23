<?php

namespace App\Http\Resources\Api\v1\Checkout;

use App\Http\Resources\Api\v1\Cart\CartProductListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
{
    
    public function toArray($request)
    {
        $carrier = null;
        if(!empty($this->carrier)){
            $carrier = [
                     "id" => $this->carrier->id, 
                     "name" => $this->carrier->name, 
                     "logo" => $this->carrier->logo, 
                     "type" => $this->carrier->type, 
                     "slug" => $this->carrier->slug, 
                     "tracking_url" => $this->carrier->tracking_url, 
                     "status" => $this->carrier->status, 
                     "created_by" =>$this->carrier->created_by, 
                     "created_at" =>$this->carrier->created_at, 
                     "updated_at" =>$this->carrier->updated_at, 
            ];
        }
        //dd($this->carrier);
        return  [
                "id" => $this->id, 
               "method_name" => $this->method_name, 
               "carrier_id" => $this->carrier_id, 
               "cost_based_on" => $this->cost_based_on, 
               "logo" => $this->logo, 
               "phone" =>$this->phone, 
               "shipment_time" => $this->shipment_time, 
               "cost" => $this->cost, 
               "minimum_shopping" =>$this->minimum_shopping, 
               "is_active" => $this->is_active, 
               "request_by_user" => $this->request_by_user,  
               "is_approved" => $this->is_approved, 
               "created_at" => $this->created_at, 
               "updated_at" => $this->updated_at, 
               "carrier" => $carrier,
        ];
    }
    
}