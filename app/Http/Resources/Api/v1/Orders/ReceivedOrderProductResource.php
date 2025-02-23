<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ReceivedOrderProductResource  extends JsonResource{

    public function toArray($collection)
    {
        $seller_product_sku = null;
        if(!empty($this->seller_product_sku))
        {



            $product = null;
            if(!empty($this->seller_product_sku->product))
            {
                $pro = $this->seller_product_sku->product;


                //Flash Deal
                $hasFlashDeal= null;
                $deal = null;
                if(!empty($pro->hasDeal)){
                    $deal = null;
                    $allPdctsPdct = $pro;
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

                 $allPdctsPdctVrntDetails = [];

               // dd($this->product->variantDetails);
                foreach ($pro->variantDetails as $allPdctsPdctVrntDetail) {

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

                $innser_product = null;
                if($pro->product)
                {
                   $innser_product = [
                        "id" => $pro->product->id,
                       "product_name" => $pro->product->product_name,
                       "product_type" => $pro->product->product_type,
                       "variant_sku_prefix" => $pro->product->variant_sku_prefix,
                       "unit_type_id" =>$pro->product->unit_type_id,
                       "brand_id" => $pro->product->brand_id,
                       "thumbnail_image_source" => $pro->product->thumbnail_image_source,
                       "media_ids" => $pro->product->media_ids,
                       "barcode_type" => $pro->product->barcode_type,
                       "model_number" => $pro->product->model_number,
                       "shipping_type" => $pro->product->shipping_type,
                       "shipping_cost" => $pro->product->shipping_cost,
                       "discount_type" => $pro->product->discount_type,
                       "discount" => $pro->product->discount,
                       "tax_type" =>$pro->product->tax_type,
                       "gst_group_id" => $pro->product->gst_group_id,
                       "tax_id" => $pro->product->tax_id,
                       "tax" => $pro->product->tax,
                       "pdf" =>$pro->product->pdf,
                       "video_provider" =>$pro->product->video_provider,
                       "video_link" => $pro->product->video_link,
                       "description" => $pro->product->description,
                       "specification" =>$pro->product->specification,
                       "minimum_order_qty" => $pro->product->minimum_order_qty,
                       "max_order_qty" => $pro->product->max_order_qty,
                       "meta_title" => $pro->product->meta_title,
                       "meta_description" => $pro->product->meta_description,
                       "meta_image" => $pro->product->meta_image,
                       "is_physical" => $pro->product->is_physical,
                       "is_approved" => $pro->product->is_approved,
                       "status" => $pro->product->status,
                       "display_in_details" => $pro->product->display_in_details,
                       "requested_by" => $pro->product->requested_by,
                       "created_by" => $pro->product->created_by,
                       "slug" => $pro->product->slug,
                       "updated_by" => $pro->product->updated_by,
                       "stock_manage" => $pro->product->stock_manage,
                       "subtitle_1" => $pro->product->subtitle_1,
                       "subtitle_2" => $pro->product->subtitle_2,
                       "created_at" => $pro->product->created_at,
                       "updated_at" => $pro->product->updated_at,
                    ];
                }

                $skus = null;
                foreach($pro->skus as $ps)
                {

                   $variations = null;
                   $attribute_value2 = null;
                   $attr = null;
                   foreach($ps->product_variations as $var)
                   {
                    $attribute_value2  =  [
                        "id" => $var->attribute_value->id,
                        "value" => $var->attribute_value->value,
                        'name' => !empty($var->attribute_value) && !empty($var->attribute_value->color) ? $var->attribute_value->color->name : null,
                        "attribute_id" =>$var->attribute_value->attribute_id,
                        "color" => !empty($var->attribute_value) && !empty($var->attribute_value->color) ? $var->attribute_value->color:null
                      ];




                       $attr = null;
                       $var_json = json_decode($var->attribute->name);
                       if (json_last_error() === JSON_ERROR_NONE){
                           foreach ($var_json as $allPdctSkuPdctVrtonAttrNm) {
                                $allPdctSkuPdctVrtonAttrName = $allPdctSkuPdctVrtonAttrNm;
                           }
                       }else{
                           $attrName = $var->attribute->name;
                       }

                       if(!empty($attrName))
                       {
                           $attr1 = [
                                "id" => $var->attribute->id,
                                "name" => $var->attribute->name,
                                "display_type" => $var->attribute->display_type,
                                "description" => $var->attribute->description,
                                "status" => $var->attribute->status,
                                "created_by" => $var->attribute->created_by,
                                "updated_by" => $var->attribute->updated_by,
                                "created_at" => $var->attribute->created_at,
                                "updated_at" => $var->attribute->updated_at,

                           ];
                       }

                       $variations[] = [
                           "id" => $var->id,
                           "product_id" => $var->product_id,
                           "product_sku_id" => $var->product_sku_id,
                           "attribute_id" => $var->attribute_id,
                           "attribute_value_id" => $var->attribute_value_id,
                           "created_by" => $var->created_by,
                           "updated_by" => $var->updated_by,
                           "created_at" => $var->created_at,
                           "updated_at" => $var->updated_at,
                           "attribute" => $attr1,
                           "attribute_value" => $attribute_value2,
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



                $product = [
                        "id" => $pro->id,
                        "user_id" => $pro->user_id,
                        "product_id" => $pro->product_id,
                        "tax" => $pro->tax,
                        "tax_type" => $pro->tax_type,
                        "discount" =>$pro->discount,
                        "discount_type" => $pro->discount_type,
                        "discount_start_date" => $pro->discount_start_date,
                        "discount_end_date" => $pro->discount_end_date,
                        "product_name" => $pro->product_name,
                        "slug" => $pro->slug,
                        "thum_img" => $pro->thum_img,
                        "status" => $pro->status,
                        "stock_manage" => $pro->stock_manage,
                        "is_approved" => $pro->is_approved,
                        "min_sell_price" => $pro->min_sell_price,
                        "max_sell_price" => $pro->max_sell_price,
                        "total_sale" => $pro->total_sale,
                        "avg_rating" => $pro->avg_rating,
                        "recent_view" => $pro->recent_view,
                        "subtitle_1" => $pro->subtitle_1,
                        "subtitle_2" => $pro->subtitle_2,
                        "created_at" => $pro->created_at,
                        "updated_at" => $pro->updated_at,
                        "MaxSellingPrice" => $pro->MaxSellingPrice,
                        "hasDeal" => $hasFlashDeal,
                        "rating" => $pro->rating,
                        "hasDiscount" => $pro->hasDiscount,
                        "ProductType" => $pro->ProductType,
                        "flash_deal" => $deal,
                        "variantDetails" => $allPdctsPdctVrntDetails,
                        "product" => $innser_product,
                        "skus" => $skus

                ];
            }

            $allProducts = [];


                $ss[]=$this->seller_product_sku->sku;
                $variations = null;
                $sku = null;
                foreach($ss as $ps)
                {

                  $variations = null;
                  $attribute_value = null;
                  $attr = null;
                  foreach($ps->product_variations as $variation)
                  {
                      $attribute_value =  [
                                        "id" => $variation->attribute_value->id,
                                        "value" => $variation->attribute_value->value,
                                        'name' => !empty($variation->attribute_value) && !empty($var->attribute_value->color) ? $variation->attribute_value->color->name : null,
                                        "attribute_id" =>$variation->attribute_value->attribute_id,
                                        "color" => !empty($variation->attribute_value) && !empty($var->attribute_value->color) ? $variation->attribute_value->color:null
                                      ];
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
                          "attribute_value" => $attribute_value,
                      ];

                  }
                    $sku = [
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
                $seller_product_sku = [
                        "id" => $this->seller_product_sku->id,
                       "user_id" => $this->seller_product_sku->user_id,
                       "product_id" => $this->seller_product_sku->product_id,
                       "product_sku_id" => $this->seller_product_sku->product_sku_id,
                       "product_stock" => $this->seller_product_sku->product_stock,
                       "purchase_price" => $this->seller_product_sku->purchase_price,
                       "selling_price" => $this->seller_product_sku->selling_price,
                       "status" => $this->seller_product_sku->status,
                       "created_at" => $this->seller_product_sku->created_at,
                       "updated_at" => $this->seller_product_sku->updated_at,
                       "product" => $product,
                       "sku" => $sku,
                       'product_variations' => $variations,
                  ];

        }

        return [
           "id" => $this->id,
           "package_id" => $this->package_id,
           "type" => $this->type,
           "product_sku_id" =>$this->product_sku_id,
           "qty" => $this->qty,
           "price" =>$this->price,
           "total_price" =>$this->total_price,
           "tax_amount" => $this->tax_amount,
           "created_at" =>$this->created_at,
           "updated_at" => $this->updated_at,
           "seller_product_sku" => $seller_product_sku,
           "gift_card" => $this->giftCard

        ];

    }

}
