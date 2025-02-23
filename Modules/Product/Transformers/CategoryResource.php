<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\v1\Product\SubCategoryResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $allProducts = null;
        if (isset($this->AllProducts)) {
            foreach ($this->AllProducts as $product) {
                $allPdctsVariantDetails = null;
                if (!empty($product->variantDetails) &&  isset($product->variantDetails)) {
                    foreach ($product->variantDetails as $productVariantDetail) {

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

                $pdctFlsDeal = $product->flash_deal;

                $allProductsPdct = null;
                if (isset($product->product)) {
                    $pdctsPdct = $product->product;

                    $allProductsPdct = [
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

                $allProductsSkus = [];
                if (isset($product->skus)) {
                    foreach ($product->skus as $allProductsku) {
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
                $hasFlashDeal= null;
                $deal = null;
                if(!empty($product->hasDeal)){
                    $deal = null;
                    $hasDeal = $product->hasDeal;
                    if(!empty($hasDeal->flashDeal)){
                        $deal = [
                                "id" => $hasDeal->flashDeal->id,
                                "title"=> $hasDeal->flashDeal->title,
                                "background_color"=> $hasDeal->flashDeal->background_color,
                                "text_color"=> $hasDeal->flashDeal->text_color,
                                "start_date"=> $hasDeal->flashDeal->start_date,
                                "end_date"=> $hasDeal->flashDeal->end_date,
                                "slug"=> $hasDeal->flashDeal->slug,
                                "banner_image"=> $hasDeal->flashDeal->banner_image,
                                "status"=> $hasDeal->flashDeal->status,
                                "is_featured"=> $hasDeal->flashDeal->is_featured,
                                "created_by"=> $hasDeal->flashDeal->created_by,
                                "updated_by"=> $hasDeal->flashDeal->updated_by,
                                "created_at"=> $hasDeal->flashDeal->created_at,
                                "updated_at"=> $hasDeal->flashDeal->updated_at

                        ];

                    }

                    $hasFlashDeal = [
                            "id"=> $hasDeal->id,
                            "flash_deal_id"=> $hasDeal->flash_deal_id,
                            "seller_product_id"=> $hasDeal->seller_product_id,
                            "discount"=> $hasDeal->discount,
                            "discount_type"=> $hasDeal->discount_type,
                            "status"=> $hasDeal->status,
                            "flash_deal" => $deal

                    ];
                }

                $allProducts[] = [
                    "id" => $product->id,
                    "user_id" => $product->user_id,
                    "product_id" => $product->product_id,
                    "tax" => $product->tax,
                    "tax_type" => $product->tax_type,
                    "discount" => $product->discount,
                    "discount_type" => $product->discount_type,
                    "discount_start_date" => $product->discount_start_date,
                    "discount_end_date" => $product->discount_end_date,
                    "product_name" => $product->product_name,
                    "slug" => $product->slug,
                    "thum_img" => $product->thum_img,
                    "status" => $product->status,
                    "stock_manage" => $product->stock_manage,
                    "is_approved" => $product->is_approved,
                    "min_sell_price" => $product->min_sell_price,
                    "max_sell_price" => $product->max_sell_price,
                    "total_sale" => $product->total_sale,
                    "avg_rating" => $product->avg_rating,
                    "recent_view" => $product->recent_view,
                    "subtitle_1" => $product->subtitle_1,
                    "subtitle_2" => $product->subtitle_2,
                    "created_at" => $product->created_at,
                    "updated_at" => $product->updated_at,
                    "variantDetails" => $allPdctsVariantDetails,
                    "MaxSellingPrice" => $product->MaxSellingPrice,
                    "hasDeal" => $hasFlashDeal,
                    "rating" => $product->rating,
                    "hasDiscount" => $product->hasDiscount,
                    "ProductType" => $product->ProductType,
                    "flash_deal" => $deal,
                    "product" => $allProductsPdct,
                    "reviews" => $product->reviews,
                    "skus" => $allProductsSkus,
                ];
            }
        }



        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "parent_id" => $this->parent_id,
            "depth_level" => $this->depth_level,
            "icon" => $this->icon,
            "searchable" => $this->searchable,
            "status" => $this->status,
            "total_sale" => $this->total_sale,
            "avg_rating" => $this->avg_rating,
            "commission_rate" => $this->commission_rate,
            "AllProducts" => $allProducts,
            "category_image" => $this->categoryImage,
            "parent_category" => new \Modules\Product\Transformers\CategoryResource($this->parentCategory),
            "sub_categories" => new SubCategoryResource($this->sub_categories),
        ];
    }
}
