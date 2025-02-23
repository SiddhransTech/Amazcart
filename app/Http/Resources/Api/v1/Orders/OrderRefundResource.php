<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderRefundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shipping_gateway = null;

        if(!empty($this->shipping_gateway))
        {
            $gateway = $this->shipping_gateway;
            $shipping_gateway = [
                "id" => $gateway->id,
                "method_name" => $gateway->method_name,
                "carrier_id"=> $gateway->carrier_id,
                "cost_based_on"=> $gateway->cost_based_on,
                "logo" => $gateway->logo,
                "phone" => $gateway->phone,
                "shipment_time" => $gateway->shipment_time,
                "cost" => $gateway->cost,
                "minimum_shopping"=> $gateway->minimum_shopping,
                "is_active"=> $gateway->is_active,
                "request_by_user" => $gateway->request_by_user,
                "is_approved" => $gateway->is_approved,
                "created_at" => $gateway->created_at,
                "updated_at" => $gateway->updated_at,
            ];
        }

        $refund_details = null;

        if(!empty($this->refund_details))
        {
            foreach($this->refund_details as $rd)
            {
                $package  = null;

                if($rd->order_package)
                {
                    $order_package = $rd->order_package;
                    $package = [
                           "id" => $order_package->id,
                           "order_id" => $order_package->order_id,
                           "carrier_order_id" =>$order_package->carrier_order_id,
                           "seller_id" => $order_package->seller_id,
                           "package_code" => $order_package->package_code,
                           "number_of_product" => $order_package->number_of_product,
                           "shipping_cost" => $order_package->shipping_cost,
                           "shipping_date" => $order_package->shipping_date,
                           "shipping_method" => $order_package->shipping_method,
                           "carrier_id" =>$order_package->id,
                           "shipped_by" => $order_package->shipped_by,
                           "is_cancelled" => $order_package->is_cancelled,
                           "is_paid" => $order_package->is_paid,
                           "cancel_reason_id" => $order_package->is_reviewed,
                           "is_reviewed" => $order_package->id,
                           "delivery_status" => $order_package->id,
                           "last_updated_by" => $order_package->last_updated_by,
                           "gst_claimed" => $order_package->gst_claimed,
                           "tax_amount" => $order_package->tax_amount,
                           "created_at" => $order_package->created_at,
                           "updated_at" => $order_package->updated_at,
                           "carrier_response" => $order_package->carrier_response,
                           "pickup_point_id" => $order_package->pickup_point_id,
                           "weight" => $order_package->weight,
                           "length" => $order_package->length,
                           "breadth" => $order_package->breadth,
                           "height" => $order_package->height,
                           "deliveryStateName" => $order_package->deliveryStateName,
                           "totalGST" => $order_package->totalGST,
                           "processes" => \App\Http\Resources\DeliveryProcessResource::collection($order_package->processes),
                           "gst_taxes" => $this->gst_taxes,

                    ];
                }






                if(!empty($rd->refund_products))
                {
                   foreach($rd->refund_products as $rp)
                   {
                        $refund_products =null;

                        if(!empty($rp->seller_product_sku->product_variations))
                        {
                            $varriations = [];
                            foreach ($rp->seller_product_sku->product_variations as $var) {
                                $attribute = null;
                                if(!empty($var->attribute))
                                {

                                   $attribute  =  [
                                        "id" => $var->attribute->id,
                                        "name" => $var->attribute->name,
                                        "display_type" => $var->attribute->display_type,
                                        "description" => $var->attribute->description,
                                        "status" => $var->attribute->status,
                                    ];
                                }

                                $attribute_value = null;
                                 if(!empty($var->attribute_value))
                                 {

                                  $attribute_value  =  [
                                        "id" => $var->attribute_value->id,
                                        "value" => $var->attribute_value->value,
                                        'name' => !empty($var->attribute_value) && !empty($var->attribute_value->color) ? $var->attribute_value->color->name : null,
                                        "attribute_id" =>$var->attribute_value->attribute_id,
                                        "color" => !empty($var->attribute_value) && !empty($var->attribute_value->color) ? $var->attribute_value->color:null
                                      ];
                                 }
                                $varriations [] = [
                                    "id" => $var->id,
                                    "product_id" => $var->product_id,
                                    "product_sku_id" => $var->product_sku_id,
                                    "attribute_id" => $var->attribute_id,
                                    "attribute_value_id" => $var->attribute_value_id,
                                    "attribute" => $attribute,
                                    "attribute_value" =>$attribute_value
                                ];
                            }
                        }

                     $refund_products[] = [
                           "id" => $rp->id,
                           "refund_request_detail_id"  => $rp->refund_request_detail_id,
                           "seller_product_sku_id" => $rp->seller_product_sku_id,
                           "refund_reason_id" => $rp->refund_reason_id,
                           "return_qty" => $rp->return_qty,
                           "return_amount" => $rp->return_amount,
                           "created_at" => $rp->created_at,
                           "updated_at" => $rp->updated_at,
                           "seller_product_sku" => [
                                "id" => $rp->seller_product_sku->id,
                                "user_id" => $rp->seller_product_sku->user_id,
                                "product_id" => $rp->seller_product_sku->product_id,
                                "product_sku_id" => $rp->seller_product_sku->product_sku_id,
                                "product_stock" => $rp->seller_product_sku->product_stock,
                                "purchase_price" =>$rp->seller_product_sku->purchase_price,
                                "selling_price" => $rp->seller_product_sku->selling_price,
                                "status" => $rp->seller_product_sku->status,
                                "created_at" => $rp->seller_product_sku->created_at,
                                "updated_at" => $rp->seller_product_sku->updated_at,
                                "product_variations" => $varriations,
                                "product" => new \App\Http\Resources\Api\v1\AllProductsResource($rp->seller_product_sku->product)
                           ],
                    ];

                   }

                }


                $refund_details[] = [
                   "id" => $rd->id,
                   "refund_request_id" =>$rd->refund_request_id,
                   "order_package_id" => $rd->order_package_id,
                   "seller_id" => $rd->seller_id,
                   "processing_state" => $rd->processing_state,
                   "carrier_order_id" => $rd->carrier_order_id,
                   "carrier_response" => $rd->carrier_response,
                   "created_at" => $rd->created_at,
                   "updated_at" => $rd->updated_at,
                   "ProcessState" => $rd->ProcessState,
                   "order_package" => $package,
                    "seller" => $rd->seller,
                   "process_refund" => $rd->process_refund,
                   "refund_products" =>$refund_products,

                ];
            }

        }
        $pick_up = null;
        if(!empty($this->pick_up_address_customer))
        {
            $pic_address = $this->pick_up_address_customer;

            $pick_up =[
                "id" => $pic_address->id,
               "customer_id" =>$pic_address->customer_id,
               "name" => $pic_address->name,
               "email" => $pic_address->email,
               "phone" => $pic_address->phone,
               "address" => $pic_address->address,
               "city" => $pic_address->getCity->name,
               "state" => $pic_address->getState->name,
               "country" => $pic_address->getCountry->name,
               "postal_code" => $pic_address->postal_code,
               "is_shipping_default" =>$pic_address->is_shipping_default,
               "is_billing_default" => $pic_address->is_billing_default,
               "created_at" => $pic_address->created_at,
               "updated_at" => $pic_address->updated_at,
               "is_updated" => $pic_address->is_updated,
            ];
        }

        return [
           "id" => $this->id,
           "customer_id" => $this->customer_id,
           "order_id" => $this->order_id,
           "refund_method" => $this->refund_method,
           "shipping_method" => $this->shipping_method,
           "shipping_method_id" => $this->shipping_method_id,
           "pick_up_address_id" => $this->pick_up_address_id,
           "drop_off_address" => $this->drop_off_address,
           "additional_info"=> $this->additional_info,
           "total_return_amount" => $this->total_return_amount,
           "refund_state"=> $this->refund_state,
           "is_confirmed" => $this->is_confirmed,
           "is_refunded" => $this->is_refunded,
           "is_completed" => $this->is_completed,
           "created_at"=> $this->created_at,
           "updated_at" => $this->updated_at,
           "CheckConfirmed" => $this->CheckConfirmed,
           "order" =>  $this->order,
           "shipping_gateway" => $shipping_gateway,
           "pick_up_address_customer" => $pick_up,
           "refund_details" => $refund_details
        ];
    }
}
