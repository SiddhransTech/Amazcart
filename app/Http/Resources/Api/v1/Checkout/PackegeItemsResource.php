<?php

namespace App\Http\Resources\Api\v1\Checkout;

use App\Http\Resources\Api\v1\Cart\CartProductListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackegeItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = null;
        if (isset($this->product)) {
            $prdct = $this->product;

            $pdctVrans = [];
            if (isset($prdct->product_variations)) {
                foreach ($prdct->product_variations as $productVariation) {
                    $productVariationAttribute = $productVariation->attribute;
                    $attr_name_json = json_decode($productVariationAttribute->name, true);
                    
                    if(json_last_error() === JSON_ERROR_NONE){
                        foreach ($attr_name_json as $pdctVrntAttrNm) {
                            $pdctVrntAttrName = $pdctVrntAttrNm;
                        }
                        
                    }else{
                        $pdctVrntAttrName =  $productVariationAttribute->name;
                    }
                    
                    
                    
                    $pdctVrans[] = [
                        "id" => $productVariation->id,
                        "product_id" => $productVariation->product_id,
                        "product_sku_id" => $productVariation->product_sku_id,
                        "attribute_id" => $productVariation->attribute_id,
                        "attribute_value_id" => $productVariation->attribute_value_id,
                        "created_by" => $productVariation->created_by,
                        "updated_by" => $productVariation->updated_by,
                        "created_at" => $productVariation->created_at,
                        "updated_at" => $productVariation->updated_at,
                        "attribute_value" => $productVariation->attribute_value,
                        "attribute" => [
                            "id" => $productVariationAttribute->id,
                            "name" => $pdctVrntAttrName,
                            "display_type" => $productVariationAttribute->display_type,
                            "description" => $productVariationAttribute->description,
                            "status" => $productVariationAttribute->status,
                            "created_by" => $productVariationAttribute->created_by,
                            "updated_by" => $productVariationAttribute->updated_by,
                            "created_at" => $productVariationAttribute->created_at,
                            "updated_at" => $productVariationAttribute->updated_at,
                        ],
                    ];
                }
            }
            
            $product = [
                "id" => $prdct->id,
                "user_id" => $prdct->user_id,
                "product_id" => $prdct->product_id,
                "product_sku_id" => $prdct->product_sku_id,
                "product_stock" => $prdct->product_stock,
                "purchase_price" => $prdct->purchase_price,
                "selling_price" => $prdct->selling_price,
                "status" => $prdct->status,
                "product" => new CartProductListResource($prdct->product),
                "sku" => $prdct->sku,
                "product_variations" => $pdctVrans,
            ];
        }
       
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "session_id" => $this->session_id,
            "seller_id" => $this->seller_id,
            "product_type" => $this->product_type,
            "product_id" => $this->product_id,
            "qty" => $this->qty,
            "price" => $this->price,
            "total_price" => $this->total_price,
            "sku" => $this->sku,
            "is_select" => $this->is_select,
            "shipping_method_id" => $this->shipping_method_id,
            "is_updated" => $this->is_updated,
            "is_buy_now" => $this->is_buy_now,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "customer" => $this->customer,
            "gift_card" => $this->giftCard,
            "product" => $product,
            "seller" => $this->seller
        ];
    }
}
