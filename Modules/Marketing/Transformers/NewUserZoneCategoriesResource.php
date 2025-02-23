<?php

namespace Modules\Marketing\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Product\Transformers\CategoryResource;

class NewUserZoneCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $category = null;
        if (isset($this->category)) {
            $cat = $this->category;

            $allProducts = [];
            if (isset($cat->AllProducts)) {
                foreach ($cat->AllProducts as $allPdct) {
                    $allPdctsVariantDetails = [];
                    if (isset($allPdct->variantDetails)) {
                        foreach ($allPdct->variantDetails as $productVariantDetail) {
                            if(!empty(json_decode($productVariantDetail->name, true))){
                                foreach (json_decode($productVariantDetail->name, true) as $name) {
                                    $productVariantDetailName = $name;
                                }
                            }else{
                                $productVariantDetailName = $productVariantDetail->name;
                            }

                            if(!empty($productVariantDetailName)){
                                $allPdctsVariantDetails[] = [
                                    "value" => $productVariantDetail->value,
                                    "code" => $productVariantDetail->code,
                                    "attr_val_id" => $productVariantDetail->attr_val_id,
                                    "name" => $productVariantDetailName,
                                    "attr_id" => $productVariantDetail->attr_id,
                                ];

                            }

                        }
                    }

                    $allPdctPdct = null;
                    if (isset($allPdct->product)) {
                        $pdctsPdct = $allPdct->product;

                        $allPdctPdct = [
                            "id" => $pdctsPdct->id,
                            "product_name" => $pdctsPdct->product_name,
                            "product_type" => $pdctsPdct->product_type,
                            "variant_sku_prefix" => $pdctsPdct->variant_sku_prefix,
                            "unit_type_id" => $pdctsPdct->unit_type_id,
                            "brand_id" => $pdctsPdct->brand_id,
                            "thumbnail_image_source" => $pdctsPdct->thumbnail_image_source,
                            "media_ids" => $pdctsPdct->media_ids,
                            "barcode_type" => $pdctsPdct->barcode_type,
                            "model_number" => $pdctsPdct->model_number,
                            "shipping_type" => $pdctsPdct->shipping_type,
                            "shipping_cost" => $pdctsPdct->shipping_cost,
                            "discount_type" => $pdctsPdct->discount_type,
                            "discount" => $pdctsPdct->discount,
                            "tax_type" => $pdctsPdct->tax_type,
                            "gst_group_id" => $pdctsPdct->gst_group_id,
                            "tax_id" => $pdctsPdct->tax_id,
                            "tax" => $pdctsPdct->tax,
                            "pdf" => $pdctsPdct->pdf,
                            "video_provider" => $pdctsPdct->video_provider,
                            "video_link" => $pdctsPdct->video_link,
                            "description" => $pdctsPdct->description,
                            "specification" => $pdctsPdct->specification,
                            "minimum_order_qty" => $pdctsPdct->minimum_order_qty,
                            "max_order_qty" => $pdctsPdct->max_order_qty,
                            "meta_title" => $pdctsPdct->meta_title,
                            "meta_description" => $pdctsPdct->meta_description,
                            "meta_image" => $pdctsPdct->meta_image,
                            "is_physical" => $pdctsPdct->is_physical,
                            "is_approved" => $pdctsPdct->is_approved,
                            "status" => $pdctsPdct->status,
                            "display_in_details" => $pdctsPdct->display_in_details,
                            "requested_by" => $pdctsPdct->requested_by,
                            "created_by" => $pdctsPdct->created_by,
                            "slug" => $pdctsPdct->slug,
                            "stock_manage" => $pdctsPdct->stock_manage,
                            "subtitle_1" => $pdctsPdct->subtitle_1,
                            "subtitle_2" => $pdctsPdct->subtitle_2,
                            "updated_by" => $pdctsPdct->updated_by,
                            "created_at" => $pdctsPdct->created_at,
                            "updated_at" => $pdctsPdct->updated_at,

                        ];
                    }

                    $allPdctSkus = [];
                    if (isset($allPdct->skus)) {
                        foreach ($allPdct->skus as $allProductsku) {
                            $allPdtsSkuPdctVrans = [];
                            if (isset($allProductsku->product_variations)) {
                                foreach ($allProductsku->product_variations as $productVariation) {
                                    $productVariationAttribute = $productVariation->attribute;

                                    if(!empty(json_decode($productVariationAttribute->name, true))){
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
                            $allPdctSkus[] = [
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

                    $allProducts[] = [
                        "id" => $allPdct->id,
                        "user_id" => $allPdct->user_id,
                        "product_id" => $allPdct->product_id,
                        "tax" => $allPdct->tax,
                        "tax_type" => $allPdct->tax_type,
                        "discount" => $allPdct->discount,
                        "discount_type" => $allPdct->discount_type,
                        "discount_start_date" => $allPdct->discount_start_date,
                        "discount_end_date" => $allPdct->discount_end_date,
                        "product_name" => $allPdct->product_name,
                        "slug" => $allPdct->slug,
                        "thum_img" => $allPdct->thum_img,
                        "status" => $allPdct->status,
                        "stock_manage" => $allPdct->stock_manage,
                        "is_approved" => $allPdct->is_approved,
                        "min_sell_price" => $allPdct->min_sell_price,
                        "max_sell_price" => $allPdct->max_sell_price,
                        "total_sale" => $allPdct->total_sale,
                        "avg_rating" => $allPdct->avg_rating,
                        "recent_view" => $allPdct->recent_view,
                        "subtitle_1" => $allPdct->subtitle_1,
                        "subtitle_2" => $allPdct->subtitle_2,
                        "created_at" => $allPdct->created_at,
                        "updated_at" => $allPdct->updated_at,
                        "variantDetails" => $allPdctsVariantDetails,
                        "MaxSellingPrice" => $allPdct->MaxSellingPrice,
                        "hasDeal" => $allPdct->hasDeal,
                        "rating" => $allPdct->rating,
                        "hasDiscount" => $allPdct->hasDiscount,
                        "ProductType" => $allPdct->ProductType,
                        "flash_deal" => $allPdct->flash_deal,
                        "product" => $allPdctPdct,
                        "reviews" => $allPdct->reviews,
                        "skus" => $allPdctSkus,
                    ];
                }
            }

            $parentCategory = null;
            if (isset($cat->parent_category)) {
                $prntCat = $cat->parent_category;

                $prntCatAllProducts = [];
                if (isset($prntCat->AllProducts)) {
                    foreach ($prntCat->AllProducts as $prntCatAllPdct) {
                        $prntCatAllPdctsVariantDetails = [];
                        if (isset($prntCatAllPdct->variantDetails)) {
                            foreach ($prntCatAllPdct->variantDetails as $prntCatPdctVrntDtl) {
                                foreach (json_decode($prntCatPdctVrntDtl->name, true) as $prntCatPdctVrntDtlNm) {
                                    $prntCatPdctVrntDtlName = $prntCatPdctVrntDtlNm;
                                }
                                $prntCatAllPdctsVariantDetails[] = [
                                    "value" => $prntCatPdctVrntDtl->value,
                                    "code" => $prntCatPdctVrntDtl->code,
                                    "attr_val_id" => $prntCatPdctVrntDtl->attr_val_id,
                                    "name" => $prntCatPdctVrntDtlName,
                                    "attr_id" => $prntCatPdctVrntDtl->attr_id,
                                ];
                            }
                        }

                        $prntCatAllPdctPdct = null;
                        if (isset($prntCatAllPdct->product)) {
                            $prntCatPdctsPdct = $prntCatAllPdct->product;
                            foreach (json_decode($prntCatPdctsPdct->translateProductName, true) as $prntCatPdctsPdctTrnsPdtNm) {
                                $prntCatPdctsPdctTrnsPdtName = $prntCatPdctsPdctTrnsPdtNm;
                            }
                            $prntCatAllPdctPdct = [
                                "id" => $prntCatPdctsPdct->id,
                                "product_name" => $prntCatPdctsPdct->product_name,
                                "product_type" => $prntCatPdctsPdct->product_type,
                                "variant_sku_prefix" => $prntCatPdctsPdct->variant_sku_prefix,
                                "unit_type_id" => $prntCatPdctsPdct->unit_type_id,
                                "brand_id" => $prntCatPdctsPdct->brand_id,
                                "thumbnail_image_source" => $prntCatPdctsPdct->thumbnail_image_source,
                                "media_ids" => $prntCatPdctsPdct->media_ids,
                                "barcode_type" => $prntCatPdctsPdct->barcode_type,
                                "model_number" => $prntCatPdctsPdct->model_number,
                                "shipping_type" => $prntCatPdctsPdct->shipping_type,
                                "shipping_cost" => $prntCatPdctsPdct->shipping_cost,
                                "discount_type" => $prntCatPdctsPdct->discount_type,
                                "discount" => $prntCatPdctsPdct->discount,
                                "tax_type" => $prntCatPdctsPdct->tax_type,
                                "gst_group_id" => $prntCatPdctsPdct->gst_group_id,
                                "tax_id" => $prntCatPdctsPdct->tax_id,
                                "tax" => $prntCatPdctsPdct->tax,
                                "pdf" => $prntCatPdctsPdct->pdf,
                                "video_provider" => $prntCatPdctsPdct->video_provider,
                                "video_link" => $prntCatPdctsPdct->video_link,
                                "description" => $prntCatPdctsPdct->description,
                                "specification" => $prntCatPdctsPdct->specification,
                                "minimum_order_qty" => $prntCatPdctsPdct->minimum_order_qty,
                                "max_order_qty" => $prntCatPdctsPdct->max_order_qty,
                                "meta_title" => $prntCatPdctsPdct->meta_title,
                                "meta_description" => $prntCatPdctsPdct->meta_description,
                                "meta_image" => $prntCatPdctsPdct->meta_image,
                                "is_physical" => $prntCatPdctsPdct->is_physical,
                                "is_approved" => $prntCatPdctsPdct->is_approved,
                                "status" => $prntCatPdctsPdct->status,
                                "display_in_details" => $prntCatPdctsPdct->display_in_details,
                                "requested_by" => $prntCatPdctsPdct->requested_by,
                                "created_by" => $prntCatPdctsPdct->created_by,
                                "slug" => $prntCatPdctsPdct->slug,
                                "stock_manage" => $prntCatPdctsPdct->stock_manage,
                                "subtitle_1" => $prntCatPdctsPdct->subtitle_1,
                                "subtitle_2" => $prntCatPdctsPdct->subtitle_2,
                                "updated_by" => $prntCatPdctsPdct->updated_by,
                                "created_at" => $prntCatPdctsPdct->created_at,
                                "updated_at" => $prntCatPdctsPdct->updated_at,
                                "translateProductName" => $prntCatPdctsPdctTrnsPdtName,
                                "TranslateProductSubtitle1" => $prntCatPdctsPdct->TranslateProductSubtitle1,
                                "TranslateProductSubtitle2" => $prntCatPdctsPdct->TranslateProductSubtitle2,
                            ];
                        }

                        $prntCatAllPdctSkus = [];
                        if (isset($prntCatAllPdct->skus)) {
                            foreach ($prntCatAllPdct->skus as $prntCatAllProductsku) {
                                $prntCatAllPdtsSkuPdctVrans = [];
                                if (isset($prntCatAllProductsku->product_variations)) {
                                    foreach ($prntCatAllProductsku->product_variations as $prntCatAllPdctSkuVrtn) {

                                        $prntCatAllPdctSkuVrtnAttr = $prntCatAllPdctSkuVrtn->attribute;

                                        foreach (json_decode($prntCatAllPdctSkuVrtnAttr->name, true) as $prntCatAllPdctSkuVrtnAttrNm) {
                                            $prntCatAllPdctSkuVrtnAttrName = $prntCatAllPdctSkuVrtnAttrNm;
                                        }

                                        $prntCatAllPdtsSkuPdctVrans[] = [
                                            "id" => $prntCatAllPdctSkuVrtn->id,
                                            "product_id" => $prntCatAllPdctSkuVrtn->product_id,
                                            "product_sku_id" => $prntCatAllPdctSkuVrtn->product_sku_id,
                                            "attribute_id" => $prntCatAllPdctSkuVrtn->attribute_id,
                                            "attribute_value_id" => $prntCatAllPdctSkuVrtn->attribute_value_id,
                                            "created_by" => $prntCatAllPdctSkuVrtn->created_by,
                                            "updated_by" => $prntCatAllPdctSkuVrtn->updated_by,
                                            "created_at" => $prntCatAllPdctSkuVrtn->created_at,
                                            "updated_at" => $prntCatAllPdctSkuVrtn->updated_at,
                                            "attribute_value" => $prntCatAllPdctSkuVrtn->attribute_value,
                                            "attribute" => [
                                                "id" => $prntCatAllPdctSkuVrtnAttr->id,
                                                "name" => $prntCatAllPdctSkuVrtnAttrName,
                                                "display_type" => $prntCatAllPdctSkuVrtnAttr->display_type,
                                                "description" => $prntCatAllPdctSkuVrtnAttr->description,
                                                "status" => $prntCatAllPdctSkuVrtnAttr->status,
                                                "created_by" => $prntCatAllPdctSkuVrtnAttr->created_by,
                                                "updated_by" => $prntCatAllPdctSkuVrtnAttr->updated_by,
                                                "created_at" => $prntCatAllPdctSkuVrtnAttr->created_at,
                                                "updated_at" => $prntCatAllPdctSkuVrtnAttr->updated_at,
                                            ],
                                        ];
                                    }
                                }

                                $prntCatAllPdctSkus[] = [
                                    "id" => $prntCatAllProductsku->id,
                                    "user_id" => $prntCatAllProductsku->user_id,
                                    "product_id" => $prntCatAllProductsku->product_id,
                                    "product_sku_id" => $prntCatAllProductsku->product_sku_id,
                                    "product_stock" => $prntCatAllProductsku->product_stock,
                                    "purchase_price" => $prntCatAllProductsku->purchase_price,
                                    "selling_price" => $prntCatAllProductsku->selling_price,
                                    "status" => $prntCatAllProductsku->status,
                                    "created_at" => $prntCatAllProductsku->created_at,
                                    "updated_at" => $prntCatAllProductsku->updated_at,
                                    "product_variations" => $prntCatAllPdtsSkuPdctVrans,
                                ];
                            }
                        }

                        $prntCatAllProducts[] = [
                            "id" => $prntCatAllPdct->id,
                            "user_id" => $prntCatAllPdct->user_id,
                            "product_id" => $prntCatAllPdct->product_id,
                            "tax" => $prntCatAllPdct->tax,
                            "tax_type" => $prntCatAllPdct->tax_type,
                            "discount" => $prntCatAllPdct->discount,
                            "discount_type" => $prntCatAllPdct->discount_type,
                            "discount_start_date" => $prntCatAllPdct->discount_start_date,
                            "discount_end_date" => $prntCatAllPdct->discount_end_date,
                            "product_name" => $prntCatAllPdct->product_name,
                            "slug" => $prntCatAllPdct->slug,
                            "thum_img" => $prntCatAllPdct->thum_img,
                            "status" => $prntCatAllPdct->status,
                            "stock_manage" => $prntCatAllPdct->stock_manage,
                            "is_approved" => $prntCatAllPdct->is_approved,
                            "min_sell_price" => $prntCatAllPdct->min_sell_price,
                            "max_sell_price" => $prntCatAllPdct->max_sell_price,
                            "total_sale" => $prntCatAllPdct->total_sale,
                            "avg_rating" => $prntCatAllPdct->avg_rating,
                            "recent_view" => $prntCatAllPdct->recent_view,
                            "subtitle_1" => $prntCatAllPdct->subtitle_1,
                            "subtitle_2" => $prntCatAllPdct->subtitle_2,
                            "created_at" => $prntCatAllPdct->created_at,
                            "updated_at" => $prntCatAllPdct->updated_at,
                            "variantDetails" => $prntCatAllPdctsVariantDetails,
                            "MaxSellingPrice" => $prntCatAllPdct->MaxSellingPrice,
                            "hasDeal" => $prntCatAllPdct->hasDeal,
                            "rating" => $prntCatAllPdct->rating,
                            "hasDiscount" => $prntCatAllPdct->hasDiscount,
                            "ProductType" => $prntCatAllPdct->ProductType,
                            "flash_deal" => $prntCatAllPdct->flash_deal,
                            "product" => $prntCatAllPdctPdct,
                            "reviews" => $prntCatAllPdct->reviews,
                            "skus" => $prntCatAllPdctSkus,
                        ];
                    }
                }

                $parentCategory = [
                    "id" => $prntCat->id,
                    "name" => $prntCat->name,
                    "slug" => $prntCat->slug,
                    "parent_id" => $prntCat->parent_id,
                    "depth_level" => $prntCat->depth_level,
                    "icon" => $prntCat->icon,
                    "searchable" => $prntCat->searchable,
                    "status" => $prntCat->status,
                    "total_sale" => $prntCat->total_sale,
                    "avg_rating" => $prntCat->avg_rating,
                    "commission_rate" => $prntCat->commission_rate,
                    "created_at" => $prntCat->created_at,
                    "updated_at" => $prntCat->updated_at,
                    "AllProducts" => $prntCatAllProducts,
                ];
            }

            $subCategories = [];
            if (isset($cat->sub_categories)) {
                foreach ($cat->sub_categories as $subCat) {
                    $subCatAllProducts = [];
                    if (isset($subCat->AllProducts)) {
                        foreach ($subCat->AllProducts as $subCatAllPdct) {
                            $subCatAllPdctsVariantDetails = [];
                            if (isset($subCatAllPdct->variantDetails)) {
                                foreach ($subCatAllPdct->variantDetails as $subCatPdctVrntDtl) {
                                    foreach (json_decode($subCatPdctVrntDtl->name, true) as $subCatPdctVrntDtlNm) {
                                        $subCatPdctVrntDtlName = $subCatPdctVrntDtlNm;
                                    }
                                    $subCatAllPdctsVariantDetails[] = [
                                        "value" => $subCatPdctVrntDtl->value,
                                        "code" => $subCatPdctVrntDtl->code,
                                        "attr_val_id" => $subCatPdctVrntDtl->attr_val_id,
                                        "name" => $subCatPdctVrntDtlName,
                                        "attr_id" => $subCatPdctVrntDtl->attr_id,
                                    ];
                                }
                            }

                            $subCatAllPdctPdct = null;
                            if (isset($subCatAllPdct->product)) {
                                $subCatPdctsPdct = $subCatAllPdct->product;
                                foreach (json_decode($subCatPdctsPdct->translateProductName, true) as $subCatPdctsPdctTrnsPdtNm) {
                                    $subCatPdctsPdctTrnsPdtName = $subCatPdctsPdctTrnsPdtNm;
                                }
                                $subCatAllPdctPdct = [
                                    "id" => $subCatPdctsPdct->id,
                                    "product_name" => $subCatPdctsPdct->product_name,
                                    "product_type" => $subCatPdctsPdct->product_type,
                                    "variant_sku_prefix" => $subCatPdctsPdct->variant_sku_prefix,
                                    "unit_type_id" => $subCatPdctsPdct->unit_type_id,
                                    "brand_id" => $subCatPdctsPdct->brand_id,
                                    "thumbnail_image_source" => $subCatPdctsPdct->thumbnail_image_source,
                                    "media_ids" => $subCatPdctsPdct->media_ids,
                                    "barcode_type" => $subCatPdctsPdct->barcode_type,
                                    "model_number" => $subCatPdctsPdct->model_number,
                                    "shipping_type" => $subCatPdctsPdct->shipping_type,
                                    "shipping_cost" => $subCatPdctsPdct->shipping_cost,
                                    "discount_type" => $subCatPdctsPdct->discount_type,
                                    "discount" => $subCatPdctsPdct->discount,
                                    "tax_type" => $subCatPdctsPdct->tax_type,
                                    "gst_group_id" => $subCatPdctsPdct->gst_group_id,
                                    "tax_id" => $subCatPdctsPdct->tax_id,
                                    "tax" => $subCatPdctsPdct->tax,
                                    "pdf" => $subCatPdctsPdct->pdf,
                                    "video_provider" => $subCatPdctsPdct->video_provider,
                                    "video_link" => $subCatPdctsPdct->video_link,
                                    "description" => $subCatPdctsPdct->description,
                                    "specification" => $subCatPdctsPdct->specification,
                                    "minimum_order_qty" => $subCatPdctsPdct->minimum_order_qty,
                                    "max_order_qty" => $subCatPdctsPdct->max_order_qty,
                                    "meta_title" => $subCatPdctsPdct->meta_title,
                                    "meta_description" => $subCatPdctsPdct->meta_description,
                                    "meta_image" => $subCatPdctsPdct->meta_image,
                                    "is_physical" => $subCatPdctsPdct->is_physical,
                                    "is_approved" => $subCatPdctsPdct->is_approved,
                                    "status" => $subCatPdctsPdct->status,
                                    "display_in_details" => $subCatPdctsPdct->display_in_details,
                                    "requested_by" => $subCatPdctsPdct->requested_by,
                                    "created_by" => $subCatPdctsPdct->created_by,
                                    "slug" => $subCatPdctsPdct->slug,
                                    "stock_manage" => $subCatPdctsPdct->stock_manage,
                                    "subtitle_1" => $subCatPdctsPdct->subtitle_1,
                                    "subtitle_2" => $subCatPdctsPdct->subtitle_2,
                                    "updated_by" => $subCatPdctsPdct->updated_by,
                                    "created_at" => $subCatPdctsPdct->created_at,
                                    "updated_at" => $subCatPdctsPdct->updated_at,
                                    "translateProductName" => $subCatPdctsPdctTrnsPdtName,
                                    "TranslateProductSubtitle1" => $subCatPdctsPdct->TranslateProductSubtitle1,
                                    "TranslateProductSubtitle2" => $subCatPdctsPdct->TranslateProductSubtitle2,
                                ];
                            }

                            $subCatAllPdctSkus = [];
                            if (isset($subCatAllPdct->skus)) {
                                foreach ($subCatAllPdct->skus as $subCatAllProductsku) {
                                    $subCatAllPdtsSkuPdctVrans = [];
                                    if (isset($subCatAllProductsku->product_variations)) {
                                        foreach ($subCatAllProductsku->product_variations as $subCatAllPdctSkuVrtn) {

                                            $subCatAllPdctSkuVrtnAttr = $subCatAllPdctSkuVrtn->attribute;

                                            foreach (json_decode($subCatAllPdctSkuVrtnAttr->name, true) as $subCatAllPdctSkuVrtnAttrNm) {
                                                $subCatAllPdctSkuVrtnAttrName = $subCatAllPdctSkuVrtnAttrNm;
                                            }

                                            $subCatAllPdtsSkuPdctVrans[] = [
                                                "id" => $subCatAllPdctSkuVrtn->id,
                                                "product_id" => $subCatAllPdctSkuVrtn->product_id,
                                                "product_sku_id" => $subCatAllPdctSkuVrtn->product_sku_id,
                                                "attribute_id" => $subCatAllPdctSkuVrtn->attribute_id,
                                                "attribute_value_id" => $subCatAllPdctSkuVrtn->attribute_value_id,
                                                "created_by" => $subCatAllPdctSkuVrtn->created_by,
                                                "updated_by" => $subCatAllPdctSkuVrtn->updated_by,
                                                "created_at" => $subCatAllPdctSkuVrtn->created_at,
                                                "updated_at" => $subCatAllPdctSkuVrtn->updated_at,
                                                "attribute_value" => $subCatAllPdctSkuVrtn->attribute_value,
                                                "attribute" => [
                                                    "id" => $subCatAllPdctSkuVrtnAttr->id,
                                                    "name" => $subCatAllPdctSkuVrtnAttrName,
                                                    "display_type" => $subCatAllPdctSkuVrtnAttr->display_type,
                                                    "description" => $subCatAllPdctSkuVrtnAttr->description,
                                                    "status" => $subCatAllPdctSkuVrtnAttr->status,
                                                    "created_by" => $subCatAllPdctSkuVrtnAttr->created_by,
                                                    "updated_by" => $subCatAllPdctSkuVrtnAttr->updated_by,
                                                    "created_at" => $subCatAllPdctSkuVrtnAttr->created_at,
                                                    "updated_at" => $subCatAllPdctSkuVrtnAttr->updated_at,
                                                ],
                                            ];
                                        }
                                    }

                                    $subCatAllPdctSkus[] = [
                                        "id" => $subCatAllProductsku->id,
                                        "user_id" => $subCatAllProductsku->user_id,
                                        "product_id" => $subCatAllProductsku->product_id,
                                        "product_sku_id" => $subCatAllProductsku->product_sku_id,
                                        "product_stock" => $subCatAllProductsku->product_stock,
                                        "purchase_price" => $subCatAllProductsku->purchase_price,
                                        "selling_price" => $subCatAllProductsku->selling_price,
                                        "status" => $subCatAllProductsku->status,
                                        "created_at" => $subCatAllProductsku->created_at,
                                        "updated_at" => $subCatAllProductsku->updated_at,
                                        "product_variations" => $subCatAllPdtsSkuPdctVrans,
                                    ];
                                }
                            }

                            $subCatAllProducts[] = [
                                "id" => $subCatAllPdct->id,
                                "user_id" => $subCatAllPdct->user_id,
                                "product_id" => $subCatAllPdct->product_id,
                                "tax" => $subCatAllPdct->tax,
                                "tax_type" => $subCatAllPdct->tax_type,
                                "discount" => $subCatAllPdct->discount,
                                "discount_type" => $subCatAllPdct->discount_type,
                                "discount_start_date" => $subCatAllPdct->discount_start_date,
                                "discount_end_date" => $subCatAllPdct->discount_end_date,
                                "product_name" => $subCatAllPdct->product_name,
                                "slug" => $subCatAllPdct->slug,
                                "thum_img" => $subCatAllPdct->thum_img,
                                "status" => $subCatAllPdct->status,
                                "stock_manage" => $subCatAllPdct->stock_manage,
                                "is_approved" => $subCatAllPdct->is_approved,
                                "min_sell_price" => $subCatAllPdct->min_sell_price,
                                "max_sell_price" => $subCatAllPdct->max_sell_price,
                                "total_sale" => $subCatAllPdct->total_sale,
                                "avg_rating" => $subCatAllPdct->avg_rating,
                                "recent_view" => $subCatAllPdct->recent_view,
                                "subtitle_1" => $subCatAllPdct->subtitle_1,
                                "subtitle_2" => $subCatAllPdct->subtitle_2,
                                "created_at" => $subCatAllPdct->created_at,
                                "updated_at" => $subCatAllPdct->updated_at,
                                "variantDetails" => $subCatAllPdctsVariantDetails,
                                "MaxSellingPrice" => $subCatAllPdct->MaxSellingPrice,
                                "hasDeal" => $subCatAllPdct->hasDeal,
                                "rating" => $subCatAllPdct->rating,
                                "hasDiscount" => $subCatAllPdct->hasDiscount,
                                "ProductType" => $subCatAllPdct->ProductType,
                                "flash_deal" => $subCatAllPdct->flash_deal,
                                "product" => $subCatAllPdctPdct,
                                "reviews" => $subCatAllPdct->reviews,
                                "skus" => $subCatAllPdctSkus,
                            ];
                        }
                    }

                    $subCategories[] = [
                        "id" => $subCat->id,
                        "name" => $subCat->name,
                        "slug" => $subCat->slug,
                        "parent_id" => $subCat->parent_id,
                        "depth_level" => $subCat->depth_level,
                        "icon" => $subCat->icon,
                        "searchable" => $subCat->searchable,
                        "status" => $subCat->status,
                        "total_sale" => $subCat->total_sale,
                        "avg_rating" => $subCat->avg_rating,
                        "commission_rate" => $subCat->commission_rate,
                        "created_at" => $subCat->created_at,
                        "updated_at" => $subCat->updated_at,
                        "AllProducts" => $subCatAllProducts,
                    ];
                }
            }

            $category = [
                "id" => $cat->id,
                "name" => $cat->name,
                "slug" => $cat->slug,
                "parent_id" => $cat->parent_id,
                "depth_level" => $cat->depth_level,
                "icon" => $cat->icon,
                "searchable" => $cat->searchable,
                "status" => $cat->status,
                "total_sale" => $cat->total_sale,
                "avg_rating" => $cat->avg_rating,
                "commission_rate" => $cat->commission_rate,
                "AllProducts" => $allProducts,
                "category_image" => $cat->category_image,
                "parent_category" => $parentCategory,
                "sub_categories" => $subCategories,
            ];
        }

        return [
            "id" => $this->id,
            "position" => $this->position,
            "category" => $category,
        ];
    }
}
