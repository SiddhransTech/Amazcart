<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecommendedProductListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $seller = null;
        if (isset($this->seller)) {
            $slr = $this->seller;
            $seller = [
                "id" => $slr->id,
                "first_name" => $slr->first_name,
                "last_name" => $slr->last_name,
                "username" => $slr->username,
                "photo" => $slr->photo,
                "role_id" => $slr->role_id,
                "mobile_verified_at" => $slr->mobile_verified_at,
                "email" => $slr->email,
                "is_verified" => $slr->is_verified,
                "verify_code" => $slr->verify_code,
                "email_verified_at" => $slr->email_verified_at,
                "notification_preference" => $slr->notification_preference,
                "is_active" => $slr->is_active,
                "avatar" => $slr->avatar,
                "slug" => $slr->slug,
                "phone" => $slr->phone,
                "date_of_birth" => $slr->date_of_birth,
                "description" => $slr->description,
                "secret_login" => $slr->secret_login,
                "lang_code" => $slr->lang_code,
                "currency_id" => $slr->currency_id,
                "currency_code" => $slr->currency_code,
                "created_at" => $slr->created_at,
                "updated_at" => $slr->updated_at,
                "others" => $slr->others,
                "bkash_number" => $slr->bkash_number,
                "name" => $slr->name,
            ];
        }

        $skus = [];
        if (isset($this->skus)) {
            foreach ($this->skus as $sku) {
                $skus[] = [
                    "id" => $sku->id,
                    "user_id" => $sku->user_id,
                    "product_id" => $sku->product_id,
                    "product_sku_id" => $sku->product_sku_id,
                    "product_stock" => $sku->product_stock,
                    "purchase_price" => $sku->purchase_price,
                    "selling_price" => $sku->selling_price,
                    "status" => $sku->status,
                    "created_at" => $sku->created_at,
                    "updated_at" => $sku->updated_at,
                    "product_variations" => $sku->product_variations,
                ];
            }
        }

        $product = null;
        if (isset($this->product)) {
            $pdct = $this->product;

            $pdctShippingMethods = [];
            if (isset($pdct->shipping_methods)) {
                foreach ($pdct->shipping_methods as $shippingMethod) {
                    $pdctShippingMethods[] = [
                        "id" => $shippingMethod->id,
                        "product_id" => $shippingMethod->product_id,
                        "shipping_method_id" => $shippingMethod->shipping_method_id,
                        "created_by" => $shippingMethod->created_by,
                        "updated_by" => $shippingMethod->updated_by,
                        "created_at" => $shippingMethod->created_at,
                        "updated_at" => $shippingMethod->updated_at,
                    ];
                }
            }

            $product = [
                "id" => $pdct->id,
                "product_name" => $pdct->product_name,
                "product_type" => $pdct->product_type,
                "variant_sku_prefix" => $pdct->variant_sku_prefix,
                "unit_type_id" => $pdct->unit_type_id,
                "brand_id" => $pdct->brand_id,
                "thumbnail_image_source" => $pdct->thumbnail_image_source,
                "media_ids" => $pdct->media_ids,
                "barcode_type" => $pdct->barcode_type,
                "model_number" => $pdct->model_number,
                "shipping_type" => $pdct->shipping_type,
                "shipping_cost" => $pdct->shipping_cost,
                "discount_type" => $pdct->discount_type,
                "discount" => $pdct->discount,
                "tax_type" => $pdct->tax_type,
                "gst_group_id" => $pdct->gst_group_id,
                "tax_id" => $pdct->tax_id,
                "tax" => $pdct->tax,
                "pdf" => $pdct->pdf,
                "video_provider" => $pdct->video_provider,
                "video_link" => $pdct->video_link,
                "description" => $pdct->description,
                "specification" => $pdct->specification,
                "minimum_order_qty" => $pdct->minimum_order_qty,
                "max_order_qty" => $pdct->max_order_qty,
                "meta_title" => $pdct->meta_title,
                "meta_description" => $pdct->meta_description,
                "meta_image" => $pdct->meta_image,
                "is_physical" => $pdct->is_physical,
                "is_approved" => $pdct->is_approved,
                "status" => $pdct->status,
                "display_in_details" => $pdct->display_in_details,
                "requested_by" => $pdct->requested_by,
                "created_by" => $pdct->created_by,
                "slug" => $pdct->slug,
                "stock_manage" => $pdct->stock_manage,
                "subtitle_1" => $pdct->subtitle_1,
                "subtitle_2" => $pdct->subtitle_2,
                "updated_by" => $pdct->updated_by,
                "created_at" => $pdct->created_at,
                "updated_at" => $pdct->updated_at,

                "shipping_methods" => $pdctShippingMethods,
            ];
        }

        $variantDetails = [];
        if(isset($this->variantDetails)){
            foreach($this->variantDetails as $variantDetail){
                foreach(json_decode($variantDetail->name, true) as $nm){
                    $name = $nm;
                }
                $variantDetails[] = [
                    "value" => $variantDetail->value,
                    "code" => $variantDetail->code,
                    "attr_val_id" => $variantDetail->attr_val_id,
                    "name" => $name,
                    "attr_id" => $variantDetail->attr_id,
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
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "variantDetails" => $variantDetails,
            "MaxSellingPrice" => $this->MaxSellingPrice,
            "hasDeal" => $this->hasDeal,
            "rating" => $this->rating,
            "hasDiscount" => $this->hasDiscount,
            "ProductType" => $this->ProductType,
            "flash_deal" => $this->flash_deal,
            "seller" => $seller,
            "reviews" => $this->reviews,
            "skus" => $skus,
            "wish_list" => $this->wish_list,
            "product" => $product,
        ];
    }
}
