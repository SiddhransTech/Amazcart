<?php

namespace App\Http\Resources\Api\v1\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartProductListResource extends JsonResource
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

            $pdctVariantDetails = [];
            if (isset($prdct->variantDetails)) {
                foreach ($prdct->variantDetails as $productVariantDetail) {
                    $product_variant_detail = json_decode($productVariantDetail->name, true);
                    if(json_last_error() === JSON_ERROR_NONE){
                        foreach ($product_variant_detail as $prdctVrntDtlNm) {
                            $productVariantDetailName = $prdctVrntDtlNm;
                        }
                    }else{
                        $productVariantDetailName = $productVariantDetail->name;
                    }
                    $pdctVariantDetails[] = [
                        "value" => $productVariantDetail->value,
                        "code" => $productVariantDetail->code,
                        "attr_val_id" => $productVariantDetail->attr_val_id,
                        "name" => $productVariantDetailName,
                        "attr_id" => $productVariantDetail->attr_id,
                    ];
                }
            }

            $prdctProduct = null;
            if (isset($prdct->product)) {
                $prdctPrdct = $prdct->product;

                $trans_late_name = json_decode($prdctPrdct->translateProductName, true);
                if(json_last_error() === JSON_ERROR_NONE){
                     foreach ($trans_late_name as $prdctPrdctTrnsPrdctNm) {
                        $prdctPrdctTrnsPrdctName = $prdctPrdctTrnsPrdctNm;
                    }
                }else{
                    $prdctPrdctTrnsPrdctName = $prdctPrdct->translateProductName;

                }





                $prdctProduct = [
                    "id" => $prdctPrdct->id,
                    "product_name" => $prdctPrdct->product_name,
                    "product_type" => $prdctPrdct->product_type,
                    "variant_sku_prefix" => $prdctPrdct->variant_sku_prefix,
                    "unit_type_id" => $prdctPrdct->unit_type_id,
                    "brand_id" => $prdctPrdct->brand_id,
                    "thumbnail_image_source" => $prdctPrdct->thumbnail_image_source,
                    "media_ids" => $prdctPrdct->media_ids,
                    "barcode_type" => $prdctPrdct->barcode_type,
                    "model_number" => $prdctPrdct->model_number,
                    "shipping_type" => $prdctPrdct->shipping_type,
                    "shipping_cost" => $prdctPrdct->shipping_cost,
                    "discount_type" => $prdctPrdct->discount_type,
                    "discount" => $prdctPrdct->discount,
                    "tax_type" => $prdctPrdct->tax_type,
                    "gst_group_id" => $prdctPrdct->gst_group_id,
                    "tax_id" => $prdctPrdct->tax_id,
                    "tax" => $prdctPrdct->tax,
                    "pdf" => $prdctPrdct->pdf,
                    "video_provider" => $prdctPrdct->video_provider,
                    "video_link" => $prdctPrdct->video_link,
                    "description" => $prdctPrdct->description,
                    "specification" => $prdctPrdct->specification,
                    "minimum_order_qty" => $prdctPrdct->minimum_order_qty,
                    "max_order_qty" => $prdctPrdct->max_order_qty,
                    "meta_title" => $prdctPrdct->meta_title,
                    "meta_description" => $prdctPrdct->meta_description,
                    "meta_image" => $prdctPrdct->meta_image,
                    "is_physical" => $prdctPrdct->is_physical,
                    "is_approved" => $prdctPrdct->is_approved,
                    "status" => $prdctPrdct->status,
                    "display_in_details" => $prdctPrdct->display_in_details,
                    "requested_by" => $prdctPrdct->requested_by,
                    "created_by" => $prdctPrdct->created_by,
                    "slug" => $prdctPrdct->slug,
                    "stock_manage" => $prdctPrdct->stock_manage,
                    "subtitle_1" => $prdctPrdct->subtitle_1,
                    "subtitle_2" => $prdctPrdct->subtitle_2,
                    "updated_by" => $prdctPrdct->updated_by,
                    "created_at" => $prdctPrdct->created_at,
                    "updated_at" => $prdctPrdct->updated_at,

                    "translateProductName" => $prdctPrdctTrnsPrdctName,

                    "TranslateProductSubtitle1" => $prdctPrdct->TranslateProductSubtitle1,
                    "TranslateProductSubtitle2" => $prdctPrdct->TranslateProductSubtitle2,
                    "shipping_methods" => $prdctPrdct->shipping_methods,
                ];
            }

            $pdctSkus = [];
            if (isset($prdct->skus)) {
                foreach ($prdct->skus as $prdctSku) {
                    $prdctSkuPdctVrans = [];
                    if (isset($prdctSku->product_variations)) {
                        foreach ($prdctSku->product_variations as $prdctVrtn) {
                            $prdctVrtnAttr = $prdctVrtn->attribute;
                            $product_attr_names = json_decode($prdctVrtnAttr->name, true);
                            if(json_last_error() === JSON_ERROR_NONE){
                                foreach ($product_attr_names as $pdctVrntAttrNm) {
                                    $pdctVrntAttrName = $pdctVrntAttrNm;
                                }
                            }else{
                                $pdctVrntAttrName = $prdctVrtnAttr->name;

                            }
                            $prdctSkuPdctVrans[] = [
                                "id" => $prdctVrtn->id,
                                "product_id" => $prdctVrtn->product_id,
                                "product_sku_id" => $prdctVrtn->product_sku_id,
                                "attribute_id" => $prdctVrtn->attribute_id,
                                "attribute_value_id" => $prdctVrtn->attribute_value_id,
                                "created_by" => $prdctVrtn->created_by,
                                "updated_by" => $prdctVrtn->updated_by,
                                "created_at" => $prdctVrtn->created_at,
                                "updated_at" => $prdctVrtn->updated_at,
                                "attribute_value" => $prdctVrtn->attribute_value,
                                "attribute" => [
                                    "id" => $prdctVrtnAttr->id,
                                    "name" => $pdctVrntAttrName,
                                    "display_type" => $prdctVrtnAttr->display_type,
                                    "description" => $prdctVrtnAttr->description,
                                    "status" => $prdctVrtnAttr->status,
                                    "created_by" => $prdctVrtnAttr->created_by,
                                    "updated_by" => $prdctVrtnAttr->updated_by,
                                    "created_at" => $prdctVrtnAttr->created_at,
                                    "updated_at" => $prdctVrtnAttr->updated_at,
                                ],
                            ];
                        }
                    }
                    $pdctSkus[] = [
                        "id" => $prdctSku->id,
                        "user_id" => $prdctSku->user_id,
                        "product_id" => $prdctSku->product_id,
                        "product_sku_id" => $prdctSku->product_sku_id,
                        "product_stock" => $prdctSku->product_stock,
                        "purchase_price" => $prdctSku->purchase_price,
                        "selling_price" => $prdctSku->selling_price,
                        "status" => $prdctSku->status,
                        "created_at" => $prdctSku->created_at,
                        "updated_at" => $prdctSku->updated_at,
                        "product_variations" => $prdctSkuPdctVrans,
                    ];
                }
            }

            //Flash Deal
            $hasFlashDeal= null;
            $deal = null;
             if(!empty($prdct->hasDeal)){
                $deal = null;
                $allPdctsPdct = $prdct;
                if(!empty($allPdctsPdct->hasDeal->flashDeal)){
                    $deal = [
                            "id" => $allPdctsPdct->hasDeal->flashDeal->id,
                            "title"=> $allPdctsPdct->hasDeal->flashDeal->title,
                            "background_color"=> $allPdctsPdct->hasDeal->flashDeal->background_color,
                            "text_color"=> $allPdctsPdct->hasDeal->flashDeal->text_color,
                            "start_date"=> $allPdctsPdct->hasDeal->flashDeal->start_date,
                            "end_date"=> $allPdctsPdct->hasDeal->flashDeal->end_date,
                            "slug"=> $allPdctsPdct->hasDeal->flashDeal->slug,
                            "banner_image"=> $allPdctsPdct->hasDeal->flashDeal->banner_image,
                            "status"=> $allPdctsPdct->hasDeal->flashDeal->status,
                            "is_featured"=> $allPdctsPdct->hasDeal->flashDeal->is_featured,
                            "created_by"=> $allPdctsPdct->hasDeal->flashDeal->created_by,
                            "updated_by"=> $allPdctsPdct->hasDeal->flashDeal->updated_by,
                            "created_at"=> $allPdctsPdct->hasDeal->flashDeal->created_at,
                            "updated_at"=> $allPdctsPdct->hasDeal->flashDeal->updated_at

                    ];

                }


                $hasFlashDeal = [
                        "id"=> $allPdctsPdct->hasDeal->id,
                        "flash_deal_id"=> $allPdctsPdct->hasDeal->flash_deal_id,
                        "seller_product_id"=> $allPdctsPdct->hasDeal->seller_product_id,
                        "discount"=> $allPdctsPdct->hasDeal->discount,
                        "discount_type"=> $allPdctsPdct->hasDeal->discount_type,
                        "status"=> $allPdctsPdct->hasDeal->status,
                        "flash_deal" => $deal

                ];
            }

            $product = [
                "id" => $prdct->id,
                "user_id" => $prdct->user_id,
                "product_id" => $prdct->product_id,
                "tax" => $prdct->tax,
                "tax_type" => $prdct->tax_type,
                "discount" => $prdct->discount,
                "discount_type" => $prdct->discount_type,
                "discount_start_date" => $prdct->discount_start_date,
                "discount_end_date" => $prdct->discount_end_date,
                "product_name" => $prdct->product_name,
                "slug" => $prdct->slug,
                "thum_img" => $prdct->thum_img,
                "status" => $prdct->status,
                "stock_manage" => $prdct->stock_manage,
                "is_approved" => $prdct->is_approved,
                "min_sell_price" => $prdct->min_sell_price,
                "max_sell_price" => $prdct->max_sell_price,
                "total_sale" => $prdct->total_sale,
                "avg_rating" => $prdct->avg_rating,
                "recent_view" => $prdct->recent_view,
                "subtitle_1" => $prdct->subtitle_1,
                "subtitle_2" => $prdct->subtitle_2,
                "created_at" => $prdct->created_at,
                "updated_at" => $prdct->updated_at,
                "thumbnail_image_source" => $prdct->thumbnail_image_source,
                "variantDetails" => $pdctVariantDetails,

                "MaxSellingPrice" => $prdct->MaxSellingPrice,
                "hasDeal" => $hasFlashDeal,
                "rating" => $prdct->rating,
                "hasDiscount" => $prdct->hasDiscount,
                "ProductType" => $prdct->ProductType,
                "flash_deal" => $deal,

                "product" => $prdctProduct,

                "skus" => $pdctSkus,
                "reviews" => $prdct->reviews,
            ];
        }

        $pdctVrans = [];
        if (isset($this->product_variations)) {
            foreach ($this->product_variations as $productVariation) {
                $productVariationAttribute = $productVariation->attribute;
                $p_variants = json_decode($productVariationAttribute->name, true);
                if(json_last_error() === JSON_ERROR_NONE){
                    foreach ($p_variants as $pdctVrntAttrNm) {
                        $pdctVrntAttrName = $pdctVrntAttrNm;
                    }

                }else{
                    $pdctVrntAttrName = $productVariationAttribute->name;
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

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "product_id" => $this->product_id,
            "product_sku_id" => $this->product_sku_id,
            "product_stock" => $this->product_stock,
            "purchase_price" => $this->purchase_price,
            "selling_price" => $this->selling_price,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "product" => $product,
            "sku" => $this->sku,

            "product_variations" => $pdctVrans,
        ];
    }
}
