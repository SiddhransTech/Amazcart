<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPackageProductResource extends JsonResource
{

    public function toArray($request)
    {
        $seller_product_sku = null;
        if(!empty($this->seller_product_sku)){

          $sellerProductSku = $this->seller_product_sku;
          if(!empty($sellerProductSku->product_variations))
          {
            $varriations = [];
            foreach ($sellerProductSku->product_variations as $var) {
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


                $varriations [] = [
                    "id" => $var->id,
                    "product_id" => $var->product_id,
                    "product_sku_id" => $var->product_sku_id,
                    "attribute_id" => $var->attribute_id,
                    "attribute_value_id" => $var->attribute_value_id,
                    "attribute" => $attribute,
                     "attribute_value" => [
                            'value' => !empty($var->attribute_value) ? $var->attribute_value->value : null,
                            'name' => !empty($var->attribute_value) && !empty($var->attribute_value->color) ? $var->attribute_value->color->name : null,
                            'id' => !empty($var->attribute_value) ? $var->attribute_value->id : null,
                            'attribute_id' => !empty($var->attribute_value) ? $var->attribute_value->attribute_id:null,
                            'color' => !empty($var->attribute_value) && !empty($var->attribute_value->color) ? $var->attribute_value->color : null,
                        ],
                ];
            }
        }
          $seller_product_sku =  [
                   "id" => $sellerProductSku->id,
                   "user_id" => $sellerProductSku->user_id,
                   "product_id" => $sellerProductSku->product_id,
                   "product_sku_id" => $sellerProductSku->product_sku_id,
                   "product_stock" => $sellerProductSku->product_stock,
                   "purchase_price" =>$sellerProductSku->purchase_price,
                   "selling_price" => $sellerProductSku->selling_price,
                   "status" => $sellerProductSku->status,
                   "created_at" => $sellerProductSku->created_at,
                   "updated_at" => $sellerProductSku->updated_at,
                   "product_variations" => $varriations,
                   "product" => new \Modules\Marketing\Transformers\NewUserZoneCategoryProducts($sellerProductSku->product)
            ];


        }

        return [
                "id" => $this->id,
               "package_id"  => $this->package_id,
               "type" =>   $this->type,
               "product_sku_id"  => $this->product_sku_id,
               "qty"  => $this->qty,
               "price" => $this->price,
               "total_price"  => $this->total_price,
               "tax_amount"  => $this->tax_amount,
               "created_at"  => $this->created_at,
               "updated_at"  => $this->updated_at,
               "seller_product_sku" => $seller_product_sku,
               "gift_card" => $this->giftCard

        ];
    }

}
