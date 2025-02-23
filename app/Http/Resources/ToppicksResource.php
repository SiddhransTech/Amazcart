<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ToppicksResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        /**
         * No need variantDetails & hasDeal. if need, we will be informed.
        */



        $allProductsSkus = [];
        if (isset($this->skus)) {
            foreach ($this->skus as $allProductsku) {
                $allPdtsSkuPdctVrans = [];
                if (isset($allProductsku->product_variations)) {
                    foreach ($allProductsku->product_variations as $productVariation) {
                        $productVariationAttribute = $productVariation->attribute;

                        if(!empty(json_decode($productVariationAttribute->name))){
                            foreach (json_decode($productVariationAttribute->name, true) as $pdctVrntAttrNm) {
                                $pdctVrntAttrName = $pdctVrntAttrNm;
                            }
                        }
                        if(!empty($pdctVrntAttrName)){
                            $allPdtsSkuPdctVrans[] = [
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
                }
                $allProductsSkus[] = [
                    "id" => $allProductsku->id,
                    "user_id" => $allProductsku->user_id,
                    "product_id" => $allProductsku->product_id,
                    "product_sku_id" => $allProductsku->product_sku_id,
                    "product_stock" => $allProductsku->product_stock,
                    "purchase_price" => $allProductsku->purchase_price,
                    "selling_price" => $allProductsku->selling_price,
                    "status" => $allProductsku->status,
                    "created_at" => $allProductsku->created_at,
                    "updated_at" => $allProductsku->updated_at,
                    "product_variations" => $allPdtsSkuPdctVrans,
                ];
            }
        }

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,
            "tax" => $this->tax,
            "tax_type" => $this->tax_type,
            "discount" => $this->discount,
            "discount_type" => $this->discount_type,
            "discount_start_date" => $this->discount_start_date,
            "discount_end_date" => $this->discount_end_date,
            "product_name" => $this->product_name,
            "slug" => $this->slug,
            "thum_img" => $this->thum_img,
            "status" => $this->status,
            "stock_manage" => $this->stock_manage,
            "is_approved" => $this->is_approved,
            "min_sell_price" => $this->min_sell_price,
            "max_sell_price" => $this->max_sell_price,
            "total_sale" => $this->total_sale,
            "avg_rating" => $this->avg_rating,
            "recent_view" => $this->recent_view,
            "subtitle_1" => $this->subtitle_1,
            "subtitle_2" => $this->subtitle_2,
             "variantDetails" => $this->variantDetails,
            "MaxSellingPrice" =>  $this->max_selling_price,
            //"hasDeal" => new FlashDealResource($this->hasDeal),
            "rating" => (float) $this->rating,
            "hasDiscount" =>  $this->discount > 0 ? "yes" : "no",
            "ProductType" =>  $this->product_type,
            "flashDeal" => new FlashDealResource($this->flashDeal),
            "product" => new ProductResource($this->product),
            "skus" => $allProductsSkus,
        ];
    }
}
