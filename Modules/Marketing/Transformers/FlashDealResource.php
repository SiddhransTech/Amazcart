<?php

namespace Modules\Marketing\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FlashDealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

       // dd($this->AllProducts);

       $products = null;
       foreach($this->AllProducts as $aPro)
       {
           $inner_product = null;

            $hasFlashDeal= null;
            $deal = null;
             if(!empty($aPro->product->hasDeal)){
                $deal = null;
                $allPdctsPdct = $aPro->product->hasDeal;
                if(!empty($aPro->product->hasDeal->flashDeal)){
                    $deal = [
                            "id" => $allPdctsPdct->flashDeal->id,
                            "title"=> $allPdctsPdct->flashDeal->title,
                            "background_color"=> $allPdctsPdct->flashDeal->background_color,
                            "text_color"=> $allPdctsPdct->flashDeal->text_color,
                            "start_date"=> $allPdctsPdct->flashDeal->start_date,
                            "end_date"=> $allPdctsPdct->flashDeal->end_date,
                            "slug"=> $allPdctsPdct->flashDeal->slug,
                            "banner_image"=> $allPdctsPdct->flashDeal->banner_image,
                            "status"=> $allPdctsPdct->flashDeal->status,
                            "is_featured"=> $allPdctsPdct->flashDeal->is_featured,
                            "created_by"=> $allPdctsPdct->flashDeal->created_by,
                            "updated_by"=> $allPdctsPdct->flashDeal->updated_by,
                            "created_at"=> $allPdctsPdct->flashDeal->created_at,
                            "updated_at"=> $allPdctsPdct->flashDeal->updated_at

                    ];

                }


                $hasFlashDeal = [
                        "id"=> $allPdctsPdct->id,
                        "flash_deal_id"=> $allPdctsPdct->flash_deal_id,
                        "seller_product_id"=> $allPdctsPdct->seller_product_id,
                        "discount"=> $allPdctsPdct->discount,
                        "discount_type"=> $allPdctsPdct->discount_type,
                        "status"=> $allPdctsPdct->status,
                        "flash_deal" => $deal

                ];
            }


           if($aPro->product){

               $skus = null;
                foreach($aPro->product->skus as $ps)
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

                   $inner_inner_product = null;

                   if($aPro->product->product)
                   {
                       $last_product = $aPro->product->product;
                       $inner_inner_product = [
                           "id" => $last_product->id,
                           "product_name" => $last_product->product_name,
                           "product_type" => $last_product->product_type,
                           "variant_sku_prefix" => $last_product->variant_sku_prefix,
                           "unit_type_id" => $last_product->unit_type_id,
                           "brand_id" => $last_product->brand_id,
                           "thumbnail_image_source" => $last_product->thumbnail_image_source,
                           "media_ids" => $last_product->media_ids,
                           "barcode_type" => $last_product->barcode_type,
                           "model_number" => $last_product->model_number,
                           "shipping_type" => $last_product->shipping_type,
                           "shipping_cost" => $last_product->shipping_cost,
                           "discount_type" => $last_product->discount_type,
                           "discount" => $last_product->discount,
                           "tax_type" => $last_product->tax_type,
                           "gst_group_id" => $last_product->gst_group_id,
                           "tax_id" => $last_product->tax_id,
                           "tax" => $last_product->tax,
                           "pdf" => $last_product->pdf,
                           "video_provider" => $last_product->video_provider,
                           "video_link" => $last_product->video_link,
                            "description" => $last_product->description,
                           "specification"=> $last_product->specification,
                           "minimum_order_qty" => $last_product->minimum_order_qty,
                           "max_order_qty"=> $last_product->max_order_qty,
                           "meta_title" =>  $last_product->meta_title,
                           "meta_description" => $last_product->meta_description,
                           "meta_image" => $last_product->meta_image,
                           "is_physical" => $last_product->is_physical,
                           "is_approved" => $last_product->is_approved,
                           "status" => $last_product->status,
                           "display_in_details" => $last_product->display_in_details,
                           "requested_by"=> $last_product->requested_by,
                           "created_by" => $last_product->created_by,
                           "slug" => $last_product->slug,
                           "updated_by" => $last_product->updated_by,
                           "stock_manage" => $last_product->stock_manage,
                           "subtitle_1" => $last_product->subtitle_1,
                           "subtitle_2" => $last_product->subtitle_2,
                           "created_at" => $last_product->created_at,
                           "updated_at" => $last_product->updated_at,

                        ];
                   }

                   $inner_product = [
                       "id" => $aPro->product->id,
                       "user_id" => $aPro->product->user_id,
                       "product_id" => $aPro->product->product_id,
                       "tax" => $aPro->product->tax,
                       "tax_type" => $aPro->product->tax_type,
                       "discount" => $aPro->product->discount,
                       "discount_type" => $aPro->product->discount_type,
                       "discount_start_date" =>$aPro->product->discount_start_date,
                       "discount_end_date" => $aPro->product->discount_end_date,
                       "product_name" => $aPro->product->product_name,
                       "slug" => $aPro->product->slug,
                       "thum_img" => $aPro->product->thum_img,
                       "status" => $aPro->product->status,
                       "stock_manage" => $aPro->product->stock_manage,
                       "is_approved" => $aPro->product->is_approved,
                       "min_sell_price" => $aPro->product->min_sell_price,
                       "max_sell_price" => $aPro->product->max_sell_price,
                       "total_sale" => $aPro->product->total_sale,
                       "avg_rating" => $aPro->product->avg_rating,
                       "recent_view" => $aPro->product->recent_view,
                       "subtitle_1" => $aPro->product->subtitle_1,
                       "subtitle_2" => $aPro->product->subtitle_2,
                       "created_at" => $aPro->product->created_at,
                       "updated_at" => $aPro->product->updated_at,
                       "variantDetails" => $aPro->product->variantDetails,
                       "MaxSellingPrice" => $aPro->product->max_selling_price,
                       "hasDeal" => $hasFlashDeal,
                       "flash_deal" => $deal,
                       "rating"=>  $aPro->product->rating,
                       "hasDiscount"=>  $aPro->product->has_discount,
                       "ProductType"=>  $aPro->product->product_type,
                       "skus" => $skus,
                       "product" => $inner_inner_product
                   ];

           }




           $products[] = [
               "id" => $aPro->id,
               "flash_deal_id" => $aPro->flash_deal_id,
               "seller_product_id" => $aPro->seller_product_id,
               "discount" => $aPro->discount,
               "discount_type" => $aPro->discount_type,
               "status" => $aPro->status,
               "created_at" => $aPro->created_at,
               "product" => $inner_product
           ];
       }



        return [
            'id' => $this->id,
            'title' =>$this->title,
            'background_color' => $this->background_color,
            'text_color' => $this->text_color,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            "slug"=> $this->slug,
            "banner_image"=> $this->banner_image,
            "status"=> $this->status,
            "is_featured"=> $this->is_featured,
            'AllProducts' => ['data' => $products],
        ];
    }
}
