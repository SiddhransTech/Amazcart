<?php

namespace App\Http\Resources\Api\v1\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpSalesProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $up_sale_seller_products = $this->up_seller_products;
        $pros = [];
        
        foreach($up_sale_seller_products as $upsale)
        {
            
           
            
            
            $variantDetails = [];
            if(!empty($upsale->variantDetails)){
                foreach($upsale->variantDetails as $variantDetail){
                    
                    $names = json_decode($variantDetail->name, true);
                    if(json_last_error() === JSON_ERROR_NONE){
                        foreach( $names as $nm){
                            $name = $nm;
                        }
                        
                    }else{
                        $name = $variantDetail->name;
                    }
                    
                    if(!empty($name)){
                        $variantDetails[] = [
                            "value" => $variantDetail->value,
                            "code" => $variantDetail->code,
                            "attr_val_id" => $variantDetail->attr_val_id,
                            "name" => $name,
                            "attr_id" => $variantDetail->attr_id,
                        ];
                    }
                    
                }
            }
            
            //Falsh Deal
            $hasFlashDeal= null;
            $deal = null;
            if(!empty($upsale->hasDeal)){
                $deal = null;
                $hasDeal = $upsale->hasDeal;
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
            
            $allProductsSkus = [];
                if (isset($upsale->skus)) {
                    foreach ($upsale->skus as $allProductsku) {
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
            
            $pros[] = [
                   "id" => $upsale->id, 
                   "user_id" =>  $upsale->user_id, 
                   "product_id" =>  $upsale->product_id, 
                   "tax" =>  $upsale->tax, 
                   "tax_type" =>  $upsale->tax_type, 
                   "discount" =>  $upsale->tax_type, 
                   "discount_type" =>  $upsale->discount_type, 
                   "discount_start_date" =>  $upsale->discount_start_date, 
                   "discount_end_date" =>  $upsale->discount_end_date, 
                   "product_name" =>  $upsale->product_name, 
                   "slug" =>  $upsale->slug, 
                   "thum_img" => $upsale->thum_img, 
                   "status" =>  $upsale->status,  
                   "stock_manage" => $upsale->stock_manage, 
                   "is_approved" =>  $upsale->is_approved, 
                   "min_sell_price" =>  $upsale->min_sell_price, 
                   "max_sell_price" =>  $upsale->max_sell_price, 
                   "total_sale" =>  $upsale->total_sale,  
                   "avg_rating" =>  $upsale->avg_rating, 
                   "recent_view" =>  $upsale->recent_view,  
                   "subtitle_1" =>  $upsale->subtitle_1, 
                   "subtitle_2" =>  $upsale->subtitle_2, 
                   "created_at" =>  $upsale->created_at, 
                   "updated_at" =>  $upsale->updated_at, 
                   "variantDetails" => $variantDetails,
                   "MaxSellingPrice" => $upsale->max_selling_price,
                   "hasDeal" => $hasFlashDeal,
                   "rating" => $upsale->rating,
                   "hasDiscount" => $upsale->hasDiscount,
                   "ProductType" => $upsale->ProductType,
                   "flash_deal" => $deal,
                   "skus" => $allProductsSkus
            ];
        }
        
        return [
              "id" => $this->id, 
               "product_id" => $this->product_id, 
               "up_sale_product_id" => $this->up_sale_product_id, 
               "created_at" => $this->created_at, 
               "updated_at" => $this->updated_at, 
               "up_seller_products" => $pros     
        ];
    }
}
