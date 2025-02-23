<?php

namespace Modules\Marketing\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NewUserZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $allProducts = [];
        if (isset($this->AllProducts)) {
            foreach ($this->AllProducts as $product) {
                $allProductsProduct = $product->product;

                $allPdctsPdctVrntDetails = [];
                if (isset($allProductsProduct->variantDetails)) {
                    foreach ($allProductsProduct->variantDetails as $allPdctsPdctVrntDetail) {
                        if(!empty(json_decode($allPdctsPdctVrntDetail->name, true))){
                            foreach (json_decode($allPdctsPdctVrntDetail->name, true) as $allPdctsPdctVrntDetailNm) {
                                $allPdctsPdctVrntDetailName = $allPdctsPdctVrntDetailNm;
                            }
                        }

                        if(!empty($allPdctsPdctVrntDetailName)){
                             $allPdctsPdctVrntDetails[] = [
                                "value" => $allPdctsPdctVrntDetail->value,
                                "code" => $allPdctsPdctVrntDetail->code,
                                "attr_val_id" => $allPdctsPdctVrntDetail->attr_val_id,
                                "name" => $allPdctsPdctVrntDetailName,
                                "attr_id" => $allPdctsPdctVrntDetail->attr_id,
                            ];

                        }

                    }
                }



                $allProductsProductProduct = !empty($allProductsProduct) ? $allProductsProduct->product: null;


                $allProductsProductSkus = [];
                if(!empty($allProductsProduct->skus)){
                    foreach ($allProductsProduct->skus as $allPdctsPdctsku) {
                        $allPdctsPdctskuPdctVariations = [];
                        if(!empty($allPdctsPdctsku->product_variations)){
                            foreach($allPdctsPdctsku->product_variations as $pdctSkuPdctVrtn){
                                $pdctSkuPdctVrtnAttr = $pdctSkuPdctVrtn->attribute;

                                if(!empty(json_decode($pdctSkuPdctVrtnAttr->name, true))){
                                    foreach(json_decode($pdctSkuPdctVrtnAttr->name, true) as $pdctSkuPdctVrtnAttrNm){
                                        $pdctSkuPdctVrtnAttrName = $pdctSkuPdctVrtnAttrNm;
                                    }
                                }

                                if(!empty($pdctSkuPdctVrtnAttrName)){
                                    $allPdctsPdctskuPdctVariations[] = [
                                        "id" => $pdctSkuPdctVrtn->id,
                                        "product_id" => $pdctSkuPdctVrtn->product_id,
                                        "product_sku_id" => $pdctSkuPdctVrtn->product_sku_id,
                                        "attribute_id" => $pdctSkuPdctVrtn->attribute_id,
                                        "attribute_value_id" => $pdctSkuPdctVrtn->attribute_value_id,
                                        "created_by" => $pdctSkuPdctVrtn->created_by,
                                        "updated_by" => $pdctSkuPdctVrtn->updated_by,
                                        "created_at" => $pdctSkuPdctVrtn->created_at,
                                        "updated_at" => $pdctSkuPdctVrtn->updated_at,
                                        "attribute_value" => $pdctSkuPdctVrtn->attribute_value,
                                        "attribute" => [
                                            "id" => $pdctSkuPdctVrtnAttr->id,
                                            "name" => $pdctSkuPdctVrtnAttrName,
                                            "display_type" => $pdctSkuPdctVrtnAttr->display_type,
                                            "description" => $pdctSkuPdctVrtnAttr->description,
                                            "status" => $pdctSkuPdctVrtnAttr->status,
                                            "created_by" => $pdctSkuPdctVrtnAttr->created_by,
                                            "updated_by" => $pdctSkuPdctVrtnAttr->updated_by,
                                            "created_at" => $pdctSkuPdctVrtnAttr->created_at,
                                            "updated_at" => $pdctSkuPdctVrtnAttr->updated_at,
                                        ],
                                    ];
                                }
                            }
                        }

                        $allProductsProductSkus[] = [
                            "id" => $allPdctsPdctsku->id,
                            "user_id" => $allPdctsPdctsku->user_id,
                            "product_id" => $allPdctsPdctsku->product_id,
                            "product_sku_id" => $allPdctsPdctsku->product_sku_id,
                            "product_stock" => $allPdctsPdctsku->product_stock,
                            "purchase_price" => $allPdctsPdctsku->purchase_price,
                            "selling_price" => $allPdctsPdctsku->selling_price,
                            "status" => $allPdctsPdctsku->status,
                            "created_at" => $allPdctsPdctsku->created_at,
                            "updated_at" => $allPdctsPdctsku->updated_at,
                            "product_variations" => $allPdctsPdctskuPdctVariations,
                        ];
                    }
                }


                $allProducts[] = [
                    "id" => $product->id,
                    "new_user_zone_id" => $product->new_user_zone_id,
                    "seller_product_id" => $product->seller_product_id,
                    "status" => $product->status,
                    "created_at" => $product->created_at,
                    "updated_at" => $product->updated_at,
                    "product" => !empty($allProductsProduct)  ? [
                        "id" => $allProductsProduct->id,
                        "user_id" => $allProductsProduct->user_id,
                        "product_id" => $allProductsProduct->product_id,
                        "tax" => $allProductsProduct->tax,
                        "tax_type" => $allProductsProduct->tax_type,
                        "discount" => $allProductsProduct->discount,
                        "discount_type" => $allProductsProduct->discount_type,
                        "discount_start_date" => $allProductsProduct->discount_start_date,
                        "discount_end_date" => $allProductsProduct->discount_end_date,
                        "product_name" => $allProductsProduct->product_name,
                        "slug" => $allProductsProduct->slug,
                        "thum_img" => $allProductsProduct->thum_img,
                        "status" => $allProductsProduct->status,
                        "stock_manage" => $allProductsProduct->stock_manage,
                        "is_approved" => $allProductsProduct->is_approved,
                        "min_sell_price" => $allProductsProduct->min_sell_price,
                        "max_sell_price" => $allProductsProduct->max_sell_price,
                        "total_sale" => $allProductsProduct->total_sale,
                        "avg_rating" => $allProductsProduct->avg_rating,
                        "recent_view" => $allProductsProduct->recent_view,
                        "subtitle_1" => $allProductsProduct->subtitle_1,
                        "subtitle_2" => $allProductsProduct->subtitle_2,
                        "created_at" => $allProductsProduct->created_at,
                        "updated_at" => $allProductsProduct->updated_at,
                        "variantDetails" => $allPdctsPdctVrntDetails,
                        "MaxSellingPrice" => $allProductsProduct->MaxSellingPrice,
                        "hasDeal" => $allProductsProduct->hasDeal,
                        "rating" => $allProductsProduct->rating,
                        "hasDiscount" => $allProductsProduct->hasDiscount,
                        "ProductType" => $allProductsProduct->ProductType,
                        "flash_deal" => $allProductsProduct->flash_deal,

                        "product" => [
                            "id" => $allProductsProductProduct->id,
                            "product_name" => $allProductsProductProduct->product_name,
                            "product_type" => $allProductsProductProduct->product_type,
                            "variant_sku_prefix" => $allProductsProductProduct->variant_sku_prefix,
                            "unit_type_id" => $allProductsProductProduct->unit_type_id,
                            "brand_id" => $allProductsProductProduct->brand_id,
                            "thumbnail_image_source" => $allProductsProductProduct->thumbnail_image_source,
                            "media_ids" => $allProductsProductProduct->media_ids,
                            "barcode_type" => $allProductsProductProduct->barcode_type,
                            "model_number" => $allProductsProductProduct->model_number,
                            "shipping_type" => $allProductsProductProduct->shipping_type,
                            "shipping_cost" => $allProductsProductProduct->shipping_cost,
                            "discount_type" => $allProductsProductProduct->discount_type,
                            "discount" => $allProductsProductProduct->discount,
                            "tax_type" => $allProductsProductProduct->tax_type,
                            "gst_group_id" => $allProductsProductProduct->gst_group_id,
                            "tax_id" => $allProductsProductProduct->tax_id,
                            "tax" => $allProductsProductProduct->tax,
                            "pdf" => $allProductsProductProduct->pdf,
                            "video_provider" => $allProductsProductProduct->video_provider,
                            "video_link" => $allProductsProductProduct->video_link,
                            "description" => $allProductsProductProduct->description,
                            "specification" => $allProductsProductProduct->specification,
                            "minimum_order_qty" => $allProductsProductProduct->minimum_order_qty,
                            "max_order_qty" => $allProductsProductProduct->max_order_qty,
                            "meta_title" => $allProductsProductProduct->meta_title,
                            "meta_description" => $allProductsProductProduct->meta_description,
                            "meta_image" => $allProductsProductProduct->meta_image,
                            "is_physical" => $allProductsProductProduct->is_physical,
                            "is_approved" => $allProductsProductProduct->is_approved,
                            "status" => $allProductsProductProduct->status,
                            "display_in_details" => $allProductsProductProduct->display_in_details,
                            "requested_by" => $allProductsProductProduct->requested_by,
                            "created_by" => $allProductsProductProduct->created_by,
                            "slug" => $allProductsProductProduct->slug,
                            "stock_manage" => $allProductsProductProduct->stock_manage,
                            "subtitle_1" => $allProductsProductProduct->subtitle_1,
                            "subtitle_2" => $allProductsProductProduct->subtitle_2,
                            "updated_by" => $allProductsProductProduct->updated_by,
                            "created_at" => $allProductsProductProduct->created_at,
                            "updated_at" => $allProductsProductProduct->updated_at,

                        ],

                        "skus" => $allProductsProductSkus,


                        "reviews" => $allProductsProduct->reviews,
                    ] : null,
                ];
            }
        }

        return [
            "id" => $this->id,
            "title" => $this->title,
            "background_color" => $this->background_color,
            "slug" => $this->slug,
            "banner_image" => $this->banner_image,
            "product_navigation_label" => $this->product_navigation_label,
            "category_navigation_label" => $this->category_navigation_label,
            "coupon_navigation_label" => $this->coupon_navigation_label,
            "product_slogan" => $this->product_slogan,
            "category_slogan" => $this->category_slogan,
            "coupon_slogan" => $this->coupon_slogan,
            "status" => $this->status,
            "AllProducts" => $allProducts,
            "categories" => NewUserZoneCategoriesResource::collection($this->categories),
            "coupon" => new NewUserZoneCouponResource($this->coupon),
            "coupon_categories" => NewUserZoneCategoriesResource::collection($this->couponCategories)
        ];
    }
}
