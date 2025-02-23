<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reviews = null;
        $products = null;
        $rvs = $this->reviews;
        foreach($rvs as $rv){
            $reviews[] = [
                       "id" => $rv->id,
                       "customer_id" => $rv->customer_id,
                       "seller_id" => $rv->seller_id,
                       "product_id"=> $rv->product_id,
                       "order_id" => $rv->order_id,
                       "package_id" => $rv->package_id, 
                       "type" =>  $rv->type,
                       "review" => $rv->review,
                       "rating" => $rv->rating,
                       "is_anonymous" => $rv->is_anonymous, 
                       "status" => $rv->status,
                       "created_at"=> $rv->created_at, 
                       "updated_at"=> $rv->updated_at,
                       "giftcard" => $rv->giftCard,
                       "product" => new \Modules\Marketing\Transformers\NewUserZoneCategoryProducts($rv->product),
                       "reply" => $rv->replay,
                       "seller" => $rv->seller,
                       "images" => $rv->images
                
            ];
            
        }
        
        return [
               "id" => $this->id, 
               "order_id" => $this->order_id, 
               "carrier_order_id" => $this->carrier_order_id, 
               "seller_id" => $this->seller_id, 
               "package_code" => $this->package_code, 
               "number_of_product" => $this->number_of_product, 
               "shipping_cost" => $this->shipping_cost, 
               "shipping_date" => $this->shipping_date, 
               "shipping_method" => $this->shipping_method, 
               "carrier_id" => $this->carrier_id, 
               "shipped_by" => $this->shipped_by, 
               "is_cancelled" => $this->is_cancelled, 
               "is_paid" => $this->is_paid, 
               "cancel_reason_id" => $this->cancel_reason_id, 
               "is_reviewed" => $this->is_reviewed, 
               "delivery_status" => $this->delivery_status, 
               "last_updated_by" => $this->last_updated_by, 
               "gst_claimed" => $this->gst_claimed,  
               "tax_amount" => $this->tax_amount, 
               "created_at" => $this->created_at, 
               "updated_at" => $this->updated_at, 
               "carrier_response" => $this->id, 
               "pickup_point_id" => $this->pickup_point_id, 
               "weight" => $this->weight, 
               "length" => $this->length, 
               "breadth" => $this->breadth, 
               "height" => $this->height,  
               "deliveryStateName" => $this->deliveryStateName, 
               "totalGST" => $this->totalGST,
               "processes" => \App\Http\Resources\DeliveryProcessResource::collection($this->processes),
               "order" => new \App\Http\Resources\Api\v1\Orders\OrderResource($this->order),
               "seller" => $this->seller,
               "delivery_states" => $this->delivery_states,
               "products" => \App\Http\Resources\Api\v1\Orders\ReceivedOrderProductResource::collection($this->products),
               "reviews" => $reviews,
               
            ];
    }
}
