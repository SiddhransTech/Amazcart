<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
                "id" => $this->id,
               "customer_id"  => $this->customer_id,
               "order_payment_id"  => $this->order_payment_id,
               "order_type"  => $this->order_type,
               "order_number"  => $this->order_number,
               "payment_type"  => $this->payment_type,
               "is_paid" => $this->is_paid,
               "is_confirmed"  => $this->is_confirmed,
               "is_completed"  => $this->is_completed,
               "is_cancelled" => $this->is_cancelled,
               "cancel_reason_id" => $this->cancel_reason_id,
               "customer_email"  => $this->customer_email,
               "customer_phone" => $this->customer_phone,
               "customer_shipping_address"  => $this->customer_shipping_address,
               "customer_billing_address"  => $this->customer_billing_address,
               "number_of_package"  => $this->number_of_package,
               "grand_total" => $this->grand_total,
               "sub_total" => $this->sub_total,
               "discount_total"  => $this->discount_total,
               "shipping_total"  => $this->shipping_total,
               "number_of_item"  => $this->number_of_item,
               "order_status"  => $this->order_status,
               "tax_amount"  => $this->tax_amount,
               "note"  => $this->note,
               "delivery_type"  => $this->delivery_type,
               "pickup_location_id"  => $this->pickup_location_id,
               "created_at"  => $this->created_at,
               "updated_at"  => $this->updated_at,
               "is_received"  => $this->is_received,
               "customer" => [
                       "id" => $this->customer->id,
                       "first_name" => $this->customer->first_name,
                       "last_name" => $this->customer->last_name,
                       "username"=> $this->customer->username,
                       "photo" => $this->customer->photo,
                       "role_id" => $this->customer->role_id,
                       "mobile_verified_at" => $this->customer->mobile_verified_at,
                       "email" => $this->customer->email,
                       "is_verified" => $this->customer->is_verified,
                       "verify_code" => $this->customer->verify_code,
                       "email_verified_at" => $this->customer->email_verified_at,
                       "notification_preference" => $this->customer->notification_preference,
                       "is_active" => $this->customer->is_active,
                       "avatar" => $this->customer->avatar,
                       "slug" => $this->customer->slug,
                       "phone" => $this->customer->phone,
                       "date_of_birth" => $this->customer->date_of_birth,
                       "description" => $this->customer->description,
                       "secret_login" => $this->customer->secret_login,
                       "lang_code" => $this->customer->lang_code,
                       "currency_id" => $this->customer->currency_id,
                       "currency_code" => $this->customer->currency_code,
                       "created_at" => $this->customer->created_at,
                       "updated_at" => $this->customer->updated_at,
                       "others" => $this->customer->others,
                       "name" => $this->customer->name,
                  ],

              "packages" => \App\Http\Resources\Api\v1\Orders\OrderPackageResource::collection($this->packages),
              "address" => new  OrderAddressResource($this->address),
              "shipping_address" => $this->shipping_address,
              "billing_address" => $this->billing_address,
              
            ];
    }
}
