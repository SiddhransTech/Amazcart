<?php

namespace Modules\Marketing\Transformers;

use App\Http\Resources\FlashDealResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NewUserZoneProductsResource extends JsonResource{

    public function toArray($request)
    {

        $allProducts = [];
        $allPdctsPdctVrntDetails = [];

        if(!empty($this->product->variantDetails)){

            foreach ($this->product->variantDetails as $allPdctsPdctVrntDetail) {

            if(!empty($allPdctsPdctVrntDetail->name)){

                $nameArray = json_decode($allPdctsPdctVrntDetail->name);

                if(json_last_error() === JSON_ERROR_NONE)
                {
                    foreach (json_decode($allPdctsPdctVrntDetail->name, true) as $allPdctsPdctVrntDetailNm) {
                        $allPdctsPdctVrntDetailName = $allPdctsPdctVrntDetailNm;
                    }
                }else{
                    $allPdctsPdctVrntDetailName = $allPdctsPdctVrntDetail->name;
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

            };

        }

        }


        $hasFlashDeal= null;
        $deal = null;
        if(!empty($this->product->hasDeal)){
            $deal = null;
            $allPdctsPdct = $this->product;
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

        $inner_product = null;

    $skus = null;

    if(!empty($this->product->skus)){
        foreach($this->product->skus as $ps)
    {

       $variations = null;
       $attribube_value = null;
       $attr = null;
       foreach($ps->product_variations as $variation)
       {
           $attribube_value = $variation->attribute_value;
           $attr = null;
           $var_json = json_decode($variation->attribute->name);
           if (json_last_error() === JSON_ERROR_NONE){
               foreach ($var_json as $allPdctSkuPdctVrtonAttrNm) {
                    $allPdctSkuPdctVrtonAttrName = $allPdctSkuPdctVrtonAttrNm;
               }
           }else{
               $attrName = $variation->attribute->name;
           }

           if(!empty($attrName))
           {
               $attr = [
                    "id" => $variation->attribute->id,
                    "name" => $variation->attribute->name,
                    "display_type" => $variation->attribute->display_type,
                    "description" => $variation->attribute->description,
                    "status" => $variation->attribute->status,
                    "created_by" => $variation->attribute->created_by,
                    "updated_by" => $variation->attribute->updated_by,
                    "created_at" => $variation->attribute->created_at,
                    "updated_at" => $variation->attribute->updated_at,

               ];
           }

           $variations[] = [
               "id" => $variation->id,
               "product_id" => $variation->product_id,
               "product_sku_id" => $variation->product_sku_id,
               "attribute_id" => $variation->attribute_id,
               "attribute_value_id" => $variation->attribute_value_id,
               "created_by" => $variation->created_by,
               "updated_by" => $variation->updated_by,
               "created_at" => $variation->created_at,
               "updated_at" => $variation->updated_at,
               "attribute" => $attr,
               "attribute_value" => $attribube_value,
           ];

       }
        $skus[] = [
           "id" => $ps->id,
           "user_id" => $ps->user_id,
           "product_id" => $ps->product_id,
           "product_sku_id" => $ps->product_sku_id,
           "product_stock" => $ps->product_stock,
           "purchase_price" => $ps->purchase_price,
           "selling_price" => $ps->selling_price,
           "status" => $ps->status,
           "created_at" => $ps->created_at,
           "updated_at" => $ps->updated_at,
           "product_variations" => $variations,
        ];
    }

    }


        if(!empty($this->product->product)){
            $inner_product = [
                "id" =>  $this->product->product->id,
                "product_name" =>  $this->product->product->product_name,
                "product_type" =>  $this->product->product->product_type,
                "variant_sku_prefix" =>  $this->product->product->variant_sku_prefix,
                "unit_type_id" =>  $this->product->product->unit_type_id,
                "brand_id" =>  $this->product->product->brand_id,
                "thumbnail_image_source" =>  $this->product->product->thumbnail_image_source,
                "media_ids" =>  $this->product->product->media_ids,
                "barcode_type" =>  $this->product->product->barcode_type,
                "model_number" =>  $this->product->product->model_number,
                "shipping_type" =>  $this->product->product->shipping_type,
                "shipping_cost" =>  $this->product->product->shipping_cost,
                "discount_type" =>  $this->product->product->discount_type,
                "discount" =>  $this->product->product->discount,
                "tax_type" =>  $this->product->product->tax_type,
                "gst_group_id" =>  $this->product->product->gst_group_id,
                "tax_id" =>  $this->product->product->tax_id,
                "tax" =>  $this->product->product->tax,
                "pdf" => $this->product->product->pdf,
                "video_provider" => $this->product->product->video_provider,
                "video_link" => $this->product->product->video_link,
                "description" => $this->product->product->description,
                "specification" => $this->product->product->specification,
                "minimum_order_qty" => $this->product->product->minimum_order_qty,
                "max_order_qty" => $this->product->product->max_order_qty,
                "meta_title" => $this->product->product->meta_title,
                "meta_description" => $this->product->product->meta_description,
                "meta_image" => $this->product->product->meta_image,
                "is_physical" => $this->product->product->is_physical,
                "is_approved" => $this->product->product->is_approved,
                "status" => $this->product->product->status,
                "display_in_details" => $this->product->product->display_in_details,
                "requested_by" => $this->product->product->requested_by,
                "created_by" => $this->product->product->created_by,
                "slug" => $this->product->product->slug,
                "updated_by" => $this->product->product->updated_by,
                "stock_manage" => $this->product->product->stock_manage,
                "subtitle_1" => $this->product->product->subtitle_1,
                "subtitle_2" => $this->product->product->subtitle_2,
                "created_at" => $this->product->product->created_at,
                "updated_at" => $this->product->product->updated_at,
            ];

        }

        $product = null;
        if(!empty($this->product))
        {
             $product = [
            "id" => $this->product->id,
            "user_id" => $this->product->user_id,
            "product_id" => $this->product->product_id,
            "tax" => $this->product->tax,
            "tax_type" => $this->product->tax_type,
            "discount" => $this->product->discount,
            "discount_type" => $this->product->discount_type,
            "discount_start_date"  => $this->product->discount_start_date,
            "discount_end_date" => $this->product->discount_end_date,
            "product_name" =>  $this->product->product_name,
            "slug" => $this->product->slug,
            "thum_img"=>  $this->product->thum_img,
            "status"=>  $this->product->status,
            "stock_manage"=> $this->product->stock_manage,
            "is_approved" =>  $this->product->is_approved,
            "min_sell_price" => $this->product->min_sell_price,
            "max_sell_price" => $this->product->max_sell_price,
            "total_sale" => $this->product->total_sale,
            "avg_rating" => $this->product->avg_rating,
            "recent_view" => $this->product->recent_view,
            "subtitle_1" => $this->product->subtitle_1,
            "subtitle_2" => $this->product->subtitle_2,
            "variantDetails" => $allPdctsPdctVrntDetails,
            "MaxSellingPrice" => $this->product->MaxSellingPrice,
            "hasDeal"=> $hasFlashDeal,
            "rating"=> $this->product->rating,
            "hasDiscount"=> $this->product->hasDiscount,
            "ProductType"=> $this->product->ProductType,
            "flash_deal"=> $deal,
            "product" => $inner_product,
            "skus" => $skus,
            "reviews" => $this->product->reviews
        ];


        }




        return [
           "id" => $this->id,
           "new_user_zone_id" => $this->new_user_zone_id,
           "seller_product_id"=> $this->seller_product_id,
           "status"=> $this->status,
           "created_at"=> $this->created_at,
           "updated_at"=> $this->updated_at,
           "product" => $product,
        ];


    }
}
