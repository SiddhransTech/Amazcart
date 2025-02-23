<?php

namespace App\Http\Resources\Api\v1\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelatedProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $relatedSellerProducts = [];
        if (isset($this->related_seller_products)) {
            foreach ($this->related_seller_products as $relatedSellerProduct) {


                $allProductsSkus = [];
                if (isset($relatedSellerProduct->skus)) {
                    foreach ($relatedSellerProduct->skus as $allProductsku) {
                        $allPdtsSkuPdctVrans = [];
                        if (isset($allProductsku->product_variations)) {
                            foreach ($allProductsku->product_variations as $productVariation) {
                                $productVariationAttribute = $productVariation->attribute;

                                if(!empty(json_decode($productVariationAttribute->name))){
                                   foreach (json_decode($productVariationAttribute->name, true) as $pdctVrntAttrNm) {
                                        $pdctVrntAttrName = $pdctVrntAttrNm;
                                    }
                                }else{
                                    $pdctVrntAttrName  = $productVariationAttribute->name;
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


                $relatedSellerProducts[] = [
                    "id" => $relatedSellerProduct->id,
                    "user_id" => $relatedSellerProduct->user_id,
                    "product_id" => $relatedSellerProduct->product_id,
                    "tax" => $relatedSellerProduct->tax,
                    "tax_type" => $relatedSellerProduct->tax_type,
                    "discount" => $relatedSellerProduct->discount,
                    "discount_type" => $relatedSellerProduct->discount_type,
                    "discount_start_date" => $relatedSellerProduct->discount_start_date,
                    "discount_end_date" => $relatedSellerProduct->discount_end_date,
                    "product_name" => $relatedSellerProduct->product_name,
                    "slug" => $relatedSellerProduct->slug,
                    "thum_img" => $relatedSellerProduct->thum_img,
                    "status" => $relatedSellerProduct->status,
                    "stock_manage" => $relatedSellerProduct->stock_manage,
                    "is_approved" => $relatedSellerProduct->is_approved,
                    "min_sell_price" => $relatedSellerProduct->min_sell_price,
                    "max_sell_price" => $relatedSellerProduct->max_sell_price,
                    "total_sale" => $relatedSellerProduct->total_sale,
                    "avg_rating" => $relatedSellerProduct->avg_rating,
                    "recent_view" => $relatedSellerProduct->recent_view,
                    "subtitle_1" => $relatedSellerProduct->subtitle_1,
                    "subtitle_2" => $relatedSellerProduct->subtitle_2,
                    "created_at" => $relatedSellerProduct->created_at,
                    "updated_at" => $relatedSellerProduct->updated_at,
                    "variantDetails" => $relatedSellerProduct->variantDetails,
                    "MaxSellingPrice" => $relatedSellerProduct->MaxSellingPrice,
                    "hasDeal" => $relatedSellerProduct->hasDeal,
                    "rating" => $relatedSellerProduct->rating,
                    "hasDiscount" => $relatedSellerProduct->hasDiscount,
                    "ProductType" => $relatedSellerProduct->ProductType,
                    "flash_deal" => $relatedSellerProduct->flash_deal,

                    "skus" => $allProductsSkus,

                    "reviews" => $relatedSellerProduct->reviews,
                ];
            }
        }

        return [
            "id" => $this->id,
            "product_id" => $this->product_id,
            "related_sale_product_id" => $this->related_sale_product_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "related_seller_products" => $relatedSellerProducts,
        ];
    }
}
