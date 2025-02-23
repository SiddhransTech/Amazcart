<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {

        return [
               "id" => $this->id,
               "customer_id" => $this->customer_id,
               "order_payment_id" => $this->order_payment_id,
               "order_type" =>$this->order_type,
               "order_number" => $this->order_number,
               "payment_type" => $this->payment_type,
               "is_paid" => $this->is_paid,
               "is_confirmed" => $this->is_confirmed,
               "is_completed" => $this->is_completed,
               "is_cancelled" => $this->is_cancelled,
               "cancel_reason_id" => $this->cancel_reason_id,
               "customer_email" => $this->customer_email,
               "customer_phone" => $this->customer_phone,
               "customer_shipping_address" => $this->customer_shipping_address,
               "customer_billing_address" => $this->customer_billing_address,
               "number_of_package" => $this->number_of_package,
               "grand_total" => $this->grand_total,
               "sub_total" => $this->sub_total,
               "discount_total" => $this->discount_total,
               "shipping_total" => $this->shipping_total,
               "number_of_item" => $this->number_of_item,
               "order_status" => $this->order_status,
               "tax_amount" =>$this->tax_amount,
               "note" => $this->note,
               "delivery_type" => $this->delivery_type,
               "pickup_location_id" => $this->pickup_location_id,
               "created_at" => $this->created_at,
               "updated_at" => $this->updated_at,
               "is_received" => $this->is_received,
               "address" => new  OrderAddressResource($this->address),

        ];
    }
}
