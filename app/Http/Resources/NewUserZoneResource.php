<?php

namespace App\Http\Resources;

use App\Http\Resources\FlashDealResource;
use Illuminate\Http\Resources\Json\JsonResource;
class NewUserZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $allProducts = [];
        if (isset($this->ProductForAPIHomePage)) {
            foreach ($this->ProductForAPIHomePage as $pdctForAPIHmPg) {
                $allProductsProduct = null;
                if (isset($pdctForAPIHmPg->product)) {
                    $allPdctsPdct = $pdctForAPIHmPg->product;
                    $allPdctsPdctVariantDetails = [];
                    if (isset($allPdctsPdct->variantDetails)) {
                        foreach ($allPdctsPdct->variantDetails as $allPdctsPdctVrntDtl) {
                            if(!empty(json_decode($allPdctsPdctVrntDtl->name, true))){
                                foreach (json_decode($allPdctsPdctVrntDtl->name, true) as $allPdctsPdctVrntDtlNm) {
                                    $allPdctsPdctVrntDtlName = $allPdctsPdctVrntDtlNm;
                                }
                            }

                            if(!empty($allPdctsPdctVrntDtlName)){
                                    $allPdctsPdctVariantDetails[] = [
                                    "value" => $allPdctsPdctVrntDtl->value,
                                    "code" => $allPdctsPdctVrntDtl->code,
                                    "attr_val_id" => $allPdctsPdctVrntDtl->attr_val_id,
                                    "name" => $allPdctsPdctVrntDtlName,
                                    "attr_id" => $allPdctsPdctVrntDtl->attr_id,
                                ];

                            }

                        }
                    }
                    $allPdctsPdctProduct = null;
                    if (isset($allPdctsPdct->product)) {
                        $allPdctsPdctPdct = $allPdctsPdct->product;

                        $allPdctsPdctProduct = [
                            "id" => $allPdctsPdctPdct->id,
                            "product_name" => $allPdctsPdctPdct->product_name,
                            "product_type" => $allPdctsPdctPdct->product_type,
                            "variant_sku_prefix" => $allPdctsPdctPdct->variant_sku_prefix,
                            "unit_type_id" => $allPdctsPdctPdct->unit_type_id,
                            "brand_id" => $allPdctsPdctPdct->brand_id,
                            "thumbnail_image_source" => $allPdctsPdctPdct->thumbnail_image_source,
                            "media_ids" => $allPdctsPdctPdct->media_ids,
                            "barcode_type" => $allPdctsPdctPdct->barcode_type,
                            "model_number" => $allPdctsPdctPdct->model_number,
                            "shipping_type" => $allPdctsPdctPdct->shipping_type,
                            "shipping_cost" => $allPdctsPdctPdct->shipping_cost,
                            "discount_type" => $allPdctsPdctPdct->discount_type,
                            "discount" => $allPdctsPdctPdct->discount,
                            "tax_type" => $allPdctsPdctPdct->tax_type,
                            "gst_group_id" => $allPdctsPdctPdct->gst_group_id,
                            "tax_id" => $allPdctsPdctPdct->tax_id,
                            "tax" => $allPdctsPdctPdct->tax,
                            "pdf" => $allPdctsPdctPdct->pdf,
                            "video_provider" => $allPdctsPdctPdct->video_provider,
                            "video_link" => $allPdctsPdctPdct->video_link,
                            "description" => $allPdctsPdctPdct->description,
                            "specification" => $allPdctsPdctPdct->specification,
                            "minimum_order_qty" => $allPdctsPdctPdct->minimum_order_qty,
                            "max_order_qty" => $allPdctsPdctPdct->max_order_qty,
                            "meta_title" => $allPdctsPdctPdct->meta_title,
                            "meta_description" => $allPdctsPdctPdct->meta_description,
                            "meta_image" => $allPdctsPdctPdct->meta_image,
                            "is_physical" => $allPdctsPdctPdct->is_physical,
                            "is_approved" => $allPdctsPdctPdct->is_approved,
                            "status" => $allPdctsPdctPdct->status,
                            "display_in_details" => $allPdctsPdctPdct->display_in_details,
                            "requested_by" => $allPdctsPdctPdct->requested_by,
                            "created_by" => $allPdctsPdctPdct->created_by,
                            "slug" => $allPdctsPdctPdct->slug,
                            "stock_manage" => $allPdctsPdctPdct->stock_manage,
                            "subtitle_1" => $allPdctsPdctPdct->subtitle_1,
                            "subtitle_2" => $allPdctsPdctPdct->subtitle_2,
                            "updated_by" => $allPdctsPdctPdct->updated_by,
                            "created_at" => $allPdctsPdctPdct->created_at,
                            "updated_at" => $allPdctsPdctPdct->updated_at,

                        ];
                    }
                    $allPdctsPdctSkus = [];
                    if (isset($allPdctsPdct->skus)) {
                        foreach ($allPdctsPdct->skus as $allPdctsPdctSku) {
                            $allPdctsPdctSkuProductVariations = [];
                            if (isset($allPdctsPdctSku->product_variations)) {
                                foreach ($allPdctsPdctSku->product_variations as $allPdctSkuPdctVrton) {
                                    $allPdctSkuPdctVrtonAttVal = $allPdctSkuPdctVrton->attribute_value;
                                    /*
                                    "attribute_value" => [
                                            "id" => 6,
                                            "value" => "#999999",
                                            "attribute_id" => 1,
                                            "created_at" => "2021-09-26T11:44:20.000000Z",
                                            "updated_at" => "2021-09-26T11:44:20.000000Z",
                                            "color" => [
                                                "id" => 6,
                                                "attribute_value_id" => 6,
                                                "name" => "Gray",
                                                "created_at" => "2021-09-26T11:44:20.000000Z",
                                                "updated_at" => "2021-09-26T11:44:20.000000Z",
                                            ],
                                        ]
                                    */
                                    $allPdctSkuPdctVrtonAttribute = null;
                                    if (isset($allPdctSkuPdctVrton->attribute)) {
                                        $allPdctSkuPdctVrtonAttr = $allPdctSkuPdctVrton->attribute;
                                        if(!empty(json_decode($allPdctSkuPdctVrtonAttr->name, true))){
                                            foreach (json_decode($allPdctSkuPdctVrtonAttr->name, true) as $allPdctSkuPdctVrtonAttrNm) {
                                                $allPdctSkuPdctVrtonAttrName = $allPdctSkuPdctVrtonAttrNm;
                                            }

                                        }

                                        if(!empty($allPdctSkuPdctVrtonAttrName)){
                                            $allPdctSkuPdctVrtonAttribute = [
                                                "id" => $allPdctSkuPdctVrtonAttr->id,
                                                "name" => $allPdctSkuPdctVrtonAttrName,
                                                "display_type" => $allPdctSkuPdctVrtonAttr->display_type,
                                                "description" => $allPdctSkuPdctVrtonAttr->description,
                                                "status" => $allPdctSkuPdctVrtonAttr->status,
                                                "created_by" => $allPdctSkuPdctVrtonAttr->created_by,
                                                "updated_by" => $allPdctSkuPdctVrtonAttr->updated_by,
                                                "created_at" => $allPdctSkuPdctVrtonAttr->created_at,
                                                "updated_at" => $allPdctSkuPdctVrtonAttr->updated_at,
                                            ];
                                        }

                                    }
                                    $allPdctsPdctSkuProductVariations[] = [
                                        "id" => $allPdctSkuPdctVrton->id,
                                        "product_id" => $allPdctSkuPdctVrton->product_id,
                                        "product_sku_id" => $allPdctSkuPdctVrton->product_sku_id,
                                        "attribute_id" => $allPdctSkuPdctVrton->attribute_id,
                                        "attribute_value_id" => $allPdctSkuPdctVrton->attribute_value_id,
                                        "created_by" => $allPdctSkuPdctVrton->created_by,
                                        "updated_by" => $allPdctSkuPdctVrton->updated_by,
                                        "created_at" => $allPdctSkuPdctVrton->created_at,
                                        "updated_at" => $allPdctSkuPdctVrton->updated_at,
                                        "attribute_value" => $allPdctSkuPdctVrtonAttVal,
                                        "attribute" => $allPdctSkuPdctVrtonAttribute,
                                    ];
                                }
                            }
                            $allPdctsPdctSkus[] = [
                                "id" => $allPdctsPdctSku->id,
                                "user_id" => $allPdctsPdctSku->user_id,
                                "product_id" => $allPdctsPdctSku->product_id,
                                "product_sku_id" => $allPdctsPdctSku->product_sku_id,
                                "product_stock" => $allPdctsPdctSku->product_stock,
                                "purchase_price" => $allPdctsPdctSku->purchase_price,
                                "selling_price" => $allPdctsPdctSku->selling_price,
                                "status" => $allPdctsPdctSku->status,
                                "created_at" => $allPdctsPdctSku->created_at,
                                "updated_at" => $allPdctsPdctSku->updated_at,
                                "product_variations" => $allPdctsPdctSkuProductVariations,
                            ];
                        }
                    }

                    $hasFlashDeal= null;
                    $deal = null;
                    if(!empty($allPdctsPdct->hasDeal)){
                        $deal = null;
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



                    $allProductsProduct = [
                        "id" => $allPdctsPdct->id,
                        "user_id" => $allPdctsPdct->user_id,
                        "product_id" => $allPdctsPdct->product_id,
                        "tax" => $allPdctsPdct->tax,
                        "tax_type" => $allPdctsPdct->tax_type,
                        "discount" => $allPdctsPdct->discount,
                        "discount_type" => $allPdctsPdct->discount_type,
                        "discount_start_date" => $allPdctsPdct->discount_start_date,
                        "discount_end_date" => $allPdctsPdct->discount_end_date,
                        "product_name" => $allPdctsPdct->product_name,
                        "slug" => $allPdctsPdct->slug,
                        "thum_img" => $allPdctsPdct->thum_img,
                        "status" => $allPdctsPdct->status,
                        "stock_manage" => $allPdctsPdct->stock_manage,
                        "is_approved" => $allPdctsPdct->is_approved,
                        "min_sell_price" => $allPdctsPdct->min_sell_price,
                        "max_sell_price" => $allPdctsPdct->max_sell_price,
                        "total_sale" => $allPdctsPdct->total_sale,
                        "avg_rating" => $allPdctsPdct->avg_rating,
                        "recent_view" => $allPdctsPdct->recent_view,
                        "subtitle_1" => $allPdctsPdct->subtitle_1,
                        "subtitle_2" => $allPdctsPdct->subtitle_2,
                        "created_at" => $allPdctsPdct->created_at,
                        "updated_at" => $allPdctsPdct->updated_at,
                        "variantDetails" => $allPdctsPdctVariantDetails,
                        "MaxSellingPrice" => $allPdctsPdct->MaxSellingPrice,
                        "hasDeal" => $hasFlashDeal,
                        "rating" => $allPdctsPdct->rating,
                        "hasDiscount" => $allPdctsPdct->hasDiscount,
                        "ProductType" => $allPdctsPdct->ProductType,
                        "flash_deal" => $deal,
                        "product" => $allPdctsPdctProduct,
                        "skus" => $allPdctsPdctSkus,
                        "reviews" => $allPdctsPdct->reviews,
                    ];
                }
                $allProducts[] = [
                    "id" => $pdctForAPIHmPg->id,
                    "new_user_zone_id" => $pdctForAPIHmPg->new_user_zone_id,
                    "seller_product_id" => $pdctForAPIHmPg->seller_product_id,
                    "status" => $pdctForAPIHmPg->status,
                    "created_at" => $pdctForAPIHmPg->created_at,
                    "updated_at" => $pdctForAPIHmPg->updated_at,
                    "product" => $allProductsProduct,
                ];
            }
        }


        $coupons = null;
        if(!empty($this->coupon) && !empty($this->coupon->coupon))
        {
            $coupons = [
                "id" => !empty($this->coupon) && !empty($this->coupon->coupon) ? $this->coupon->coupon->id : null,
                "title" => !empty($this->coupon) && !empty($this->coupon->coupon) ? $this->coupon->coupon->title:'',
                "coupon_code" => $this->coupon->coupon->coupon_code,
                "start_date" => $this->coupon->coupon->start_date,
                "end_date" => $this->coupon->coupon->end_date,
                "discount" => $this->coupon->coupon->discount,
                "discount_type" => $this->coupon->coupon->discount_type,
                "minimum_shopping" => $this->coupon->coupon->minimum_shopping,
                "maximum_discount" => $this->coupon->coupon->maximum_discount
            ];
        }

        return [
            "id" =>  $this->id,
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
            "coupon" => $coupons,
            'AllProducts' => $allProducts
        ];
    }
}
