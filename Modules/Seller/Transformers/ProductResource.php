<?php

namespace Modules\Seller\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $flashDeal = null;
        if (isset($this->flash_deal)) {
            $fd = $this->flash_deal;
            $flash_deal = null;
            if (isset($fd->flash_deal)) {
                $fdl = $fd->flash_deal;
                $flash_deal = [
                    "id" => $fdl->id,
                    "title" => $fdl->title,
                    "background_color" => $fdl->background_color,
                    "text_color" => $fdl->text_color,
                    "start_date" => $fdl->start_date,
                    "end_date" => $fdl->end_date,
                    "slug" => $fdl->slug,
                    "banner_image" => $fdl->banner_image,
                    "status" => $fdl->status,
                    "is_featured" => $fdl->is_featured,
                    "created_by" => $fdl->created_by,
                    "updated_by" => $fdl->updated_by,
                    "created_at" => $fdl->created_at,
                    "updated_at" => $fdl->updated_at,
                ];
            }
            $flashDeal = [
                "id" => $fd->id,
                "flash_deal_id" => $fd->flash_deal_id,
                "seller_product_id" => $fd->seller_product_id,
                "discount" => $fd->discount,
                "discount_type" => $fd->display_type,
                "status" => $fd->status,
                "created_at" => $fd->created_at,
                "updated_at" => $fd->updated_at,
                "flash_deal" => $flash_deal,
            ];
        }

        $product = null;
        if (isset($this->product)) {
            $goods = $this->product;

            $productNameJson = json_decode($goods->translateProductName, true);

            //Brand
            $brand = null;
            if (isset($goods->brand)) {
                $bnd = $goods->brand;
                $brand = [
                    // 'test' => $bnd,
                    "id" => $bnd->id,
                    "name" => $bnd->name,
                    "logo" => $bnd->logo,
                    "description" => $bnd->description,
                    "link" => $bnd->link,
                    "status" => $bnd->status,
                    "featured" => $bnd->featured,
                    "meta_title" => $bnd->meta_title,
                    "meta_description" => $bnd->meta_description,
                    "sort_id" => $bnd->sort_id ? $bnd->sort_id : null,
                    "total_sale" => $bnd->total_sale,
                    "avg_rating" => $bnd->avg_rating,
                    "slug" => $bnd->slug,
                    "created_by" => $bnd->created_by,
                    "updated_by" => $bnd->updated_by,
                    "created_at" => $bnd->created_at,
                    "updated_at" => $bnd->updated_at,
                ];
            }

            //Categories
            $categories = [];
            if (isset($goods->categories)) {
                foreach ($goods->categories as $category) {
                    $allProducts = [];
                    if (isset($category->AllProducts)) {
                        foreach ($category->AllProducts as $product) {
                            $variantDetails = [];
                            if (isset($product->variantDetails) && $product->variantDetails != null) {
                                foreach ($product->variantDetails as $variant) {
                                    $varNameJson = json_decode($variant->name, true);

                                    if(!empty($varNameJson)){
                                        foreach ($varNameJson as $key => $var_name) {
                                            $varName = $var_name;
                                        }
                                    }
                                    if(!empty($varName)){
                                        $variantDetails[] = [
                                            "value" => (array)$variant->value,
                                            "code" => (array)$variant->code,
                                            "attr_val_id" => (array)$variant->attr_val_id,
                                            "name" => $varName,
                                            "attr_id" => $variant->attr_id,
                                        ];

                                    }

                                }
                            }



                            $prodct = null;
                            if (isset($product->product)) {
                                $prdt = $product->product;
                                $prdtTraNameJson = json_decode($prdt->translateProductName, true);

                                $prodct = [
                                    "id" => $prdt->id,
                                    "product_name" => $prdt->product_name,
                                    "product_type" => $prdt->product_type,
                                    "variant_sku_prefix" => $prdt->variant_sku_prefix,
                                    "unit_type_id" => $prdt->unit_type_id,
                                    "brand_id" => $prdt->brand_id,
                                    "thumbnail_image_source" => $prdt->thumbnail_image_source,
                                    "media_ids" => $prdt->media_ids,
                                    "barcode_type" => $prdt->barcode_type,
                                    "model_number" => $prdt->model_number,
                                    "shipping_type" => $prdt->shipping_type,
                                    "shipping_cost" => $prdt->shipping_cost,
                                    "discount_type" => $prdt->display_type,
                                    "discount" => $prdt->discount,
                                    "tax_type" => $prdt->tax_type,
                                    "gst_group_id" => $prdt->gst_group_id,
                                    "tax_id" => $prdt->tax_id,
                                    "tax" => $prdt->tax,
                                    "pdf" => $prdt->pdf,
                                    "video_provider" => $prdt->video_provider,
                                    "video_link" => $prdt->video_link,
                                    "description" => $prdt->description,
                                    "specification" => $prdt->specification,
                                    "minimum_order_qty" => $prdt->minimum_order_qty,
                                    "max_order_qty" => $prdt->max_order_qty,
                                    "meta_title" => $prdt->meta_title,
                                    "meta_description" => $prdt->meta_description,
                                    "meta_image" => $prdt->meta_image,
                                    "is_physical" => $prdt->is_physical,
                                    "is_approved" => $prdt->is_approved,
                                    "status" => $prdt->status,
                                    "display_in_details" => $prdt->display_in_details,
                                    "requested_by" => $prdt->requested_by,
                                    "created_by" => $prdt->created_by,
                                    "slug" => $prdt->slug,
                                    "stock_manage" => $prdt->stock_manage,
                                    "subtitle_1" => $prdt->subtitle_1,
                                    "subtitle_2" => $prdt->subtitle_2,
                                    "updated_by" => $prdt->updated_by,
                                    "created_at" => $prdt->created_at,
                                    "updated_at" => $prdt->updated_at,

                                ];
                            }

                            $productSkus = [];
                            if (isset($product->skus)) {
                                foreach ($product->skus as $sku) {
                                    $skuProductVariantions = [];
                                    if (isset($sku->product_variations)) {
                                        foreach ($sku->product_variations as $variation) {
                                            $varAttribute = null;
                                            if (isset($variation->attribute_value)) {
                                                $vAtt = $variation->attribute_value;
                                                $vAttColor = null;
                                                if (isset($vAtt->color)) {
                                                    $vAttClor = $vAtt->color;
                                                    $vAttColor = [
                                                        "id" => $vAttClor->id,
                                                        "attribute_value_id" => $vAttClor->attribute_value_id,
                                                        "name" => $vAttClor->name,
                                                        "created_at" => $vAttClor->created_at,
                                                        "updated_at" => $vAttClor->updated_at,
                                                    ];
                                                }
                                                $varAttribute = [
                                                    "id" => $vAtt->id,
                                                    "value" => $vAtt->value,
                                                    "attribute_id" => $vAtt->attribute_id,
                                                    "created_at" => $vAtt->created_at,
                                                    "updated_at" => $vAtt->updated_at,
                                                    "color" => $vAttColor,
                                                ];
                                            }

                                            $variAtt = null;
                                            if (isset($variation->attribute)) {
                                                $varAtt = $variation->attribute;
                                                $varAttNameJson = json_decode($varAtt->name, true);
                                                if(!empty($varAttNameJson)){
                                                    foreach ($varAttNameJson as $key => $varAtName) {
                                                        $varAttName = $varAtName;
                                                    }

                                                }

                                                if(!empty($varAttName)){
                                                    $variAtt = [
                                                        "id" => $varAtt->id,
                                                        "name" => $varAttName,
                                                        "display_type" => $varAtt->display_type,
                                                        "description" => $varAtt->description,
                                                        "status" => $varAtt->status,
                                                        "created_by" => $varAtt->created_by,
                                                        "updated_by" => $varAtt->updated_by,
                                                        "created_at" => $varAtt->created_at,
                                                        "updated_at" => $varAtt->updated_at,
                                                    ];

                                                }

                                            }

                                            $skuProductVariantions[] = [
                                                "id" => $variation->id,
                                                "product_id" => $variation->product_id,
                                                "product_sku_id" => $variation->product_sku_id,
                                                "attribute_id" => $variation->attribute_id,
                                                "attribute_value_id" => $variation->attribute_value_id,
                                                "created_by" => $variation->created_by,
                                                "updated_by" => $variation->updated_by,
                                                "created_at" => $variation->created_at,
                                                "updated_at" => $variation->updated_at,
                                                "attribute_value" => $varAttribute,
                                                "attribute" => $variAtt,
                                            ];
                                        }
                                    }
                                    $productSkus[] = [
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
                                        "product_variations" => $skuProductVariantions,
                                    ];
                                }
                            }



                             $hasFlashDeal= null;
                             $deal = null;
                             if(!empty($product->hasDeal)){
                                $deal = null;
                                $allPdctsPdct = $product;
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
                                "variantDetails" => $variantDetails,
                                "MaxSellingPrice" => $product->MaxSellingPrice,
                                "hasDeal" => $hasFlashDeal,
                                "rating" => $product->rating,
                                "hasDiscount" => $product->hasDiscount,
                                "ProductType" => $product->ProductType,
                                "flash_deal" => $deal,
                                "product" => $prodct,
                                "reviews" => $product->reviews,
                                "skus" => $productSkus,
                            ];
                        }
                    }

                    $categoryPivot = null;
                    if (isset($category->pivot)) {
                        $catPivot = $category->pivot;
                        $categoryPivot = [
                            "product_id" => $catPivot->product_id,
                            "category_id" => $catPivot->category_id,
                        ];
                    }

                    $categories[] = [
                        "id" => $category->id,
                        "name" => $category->name,
                        "slug" => $category->slug,
                        "parent_id" => $category->parent_id,
                        "depth_level" => $category->depth_level,
                        "icon" => $category->icon,
                        "searchable" => $category->searchable,
                        "status" => $category->status,
                        "total_sale" => $category->total_sale,
                        "avg_rating" => $category->avg_rating,
                        "commission_rate" => $category->commission_rate,
                        "created_at" => $category->created_at,
                        "updated_at" => $category->updated_at,
                        "AllProducts" => $allProducts,
                        "pivot" => $categoryPivot
                    ];
                }
            }

            //Unit Type
            $unitType = null;
            if (isset($goods->unitType)) {
                $uType = $goods->unitType;
                $unitType = [
                    "id" => $uType->id,
                    "name" => $uType->name,
                    "description" => $uType->description,
                    "status" => $uType->status,
                    "created_by" => $uType->created_by,
                    "updated_by" => $uType->updated_by,
                    "created_at" => $uType->created_at,
                    "updated_at" => $uType->updated_at,
                    "translateName" => $uType->translateName,
                ];
            }

            //Variations
            $productVariations = [];
            if (isset($goods->productVariations)) {
                $productVariations = $goods->productVariations;
            }

            //Skus
            $productSkus = [];
            if (isset($goods->skus)) {
                foreach ($goods->skus as $proSku) {
                    $productSkus[] = [
                        "id" => $proSku->id,
                        "product_id" => $proSku->product_id,
                        "sku" => $proSku->sku,
                        "purchase_price" => $proSku->purchase_price,
                        "selling_price" => $proSku->selling_price,
                        "additional_shipping" => $proSku->additional_shipping,
                        "variant_image" => $proSku->variant_image,
                        "status" => $proSku->status,
                        "product_stock" => $proSku->product_stock,
                        "track_sku" => $proSku->track_sku,
                        "weight" => $proSku->weight,
                        "length" => $proSku->length,
                        "breadth" => $proSku->breadth,
                        "height" => $proSku->height,
                        "created_at" => $proSku->created_at,
                        "updated_at" => $proSku->updated_at,
                    ];
                }
            }

            //Tags
            $productTags = [];
            if (isset($goods->tags)) {
                foreach ($goods->tags as $productTag) {
                    $productTagPivot = null;
                    if (isset($productTag->pivot)) {
                        $proTagPivot = $productTag->pivot;
                        $productTagPivot = [
                            "product_id" => $proTagPivot->id,
                            "tag_id" => $proTagPivot->tag_id,
                        ];
                    }
                    $productTags[] = [
                        "id" => $productTag->id,
                        "name" => $productTag->name,
                        "url" => $productTag->url,
                        "created_at" => $productTag->created_at,
                        "updated_at" => $productTag->updated_at,
                        "pivot" => $productTagPivot,
                    ];
                }
            }

            //Gallery Image
            $productGalleryImages = [];
            if (isset($goods->gallary_images)) {
                foreach ($goods->gallary_images as $productGalleryImage) {
                    $productGalleryImages[] = [
                        "id" => $productGalleryImage->id,
                        "product_id" => $productGalleryImage->product_id,
                        "images_source" => $productGalleryImage->images_source,
                        "media_id" => $productGalleryImage->media_id,
                        "created_at" => $productGalleryImage->created_at,
                        "updated_at" => $productGalleryImage->updated_at,
                    ];
                }
            }

            //Related Products
            $productRelatedProducts = [];
            if (isset($goods->related_products)) {
                foreach ($goods->related_products as $productRelatedProduct) {
                    $productRelatedProducts[] = $productRelatedProduct;
                }
            }

            //Up Sales
            $productUpSales = [];
            if (isset($goods->up_sales)) {
                $productUpSales = $goods->up_sales;
            }

            //Cross Sales
            $productCrossSales = [];
            if (isset($goods->cross_sales)) {
                $productCrossSales = $goods->cross_sales;
            }

            //Shipping Methods
            $productShippingMethods = [];
            if (isset($goods->shipping_methods)) {
                $productShippingMethods = $goods->shipping_methods;

            }

            $product = [
                "id" => $goods->id,
                "product_name" => $goods->product_name,
                "product_type" => $goods->product_type,
                "variant_sku_prefix" => $goods->variant_sku_prefix,
                "unit_type_id" => $goods->unit_type_id,
                "brand_id" => $goods->brand_id,
                "thumbnail_image_source" => $goods->thumbnail_image_source,
                "media_ids" => $goods->media_ids,
                "barcode_type" => $goods->barcode_type,
                "model_number" => $goods->model_number,
                "shipping_type" => $goods->shipping_type,
                "shipping_cost" => $goods->shipping_cost,
                "discount_type" => $goods->discount_type,
                "discount" => $goods->discount,
                "tax_type" => $goods->tax_type,
                "gst_group_id" => $goods->gst_group_id,
                "tax_id" => $goods->tax_id,
                "tax" => $goods->tax,
                "pdf" => $goods->pdf,
                "video_provider" => $goods->video_provider,
                "video_link" => $goods->video_link,
                "description" => $goods->description,
                "specification" => $goods->specification,
                "minimum_order_qty" => $goods->minimum_order_qty,
                "max_order_qty" => $goods->max_order_qty,
                "meta_title" => $goods->meta_title,
                "meta_description" => $goods->meta_description,
                "meta_image" => $goods->meta_image,
                "is_physical" => $goods->is_physical,
                "is_approved" => $goods->is_approved,
                "status" => $goods->status,
                "display_in_details" => $goods->display_in_details,
                "requested_by" => $goods->requested_by,
                "created_by" => $goods->created_by,
                "slug" => $goods->slug,
                "stock_manage" => $goods->stock_manage,
                "subtitle_1" => $goods->subtitle_1,
                "subtitle_2" => $goods->subtitle_2,
                "updated_by" => $goods->updated_by,
                "created_at" => $goods->created_at,
                "updated_at" => $goods->updated_at,


                "brand" => $brand,

                "categories" => $categories,

                "unit_type" => $unitType,

                "variations" => $productVariations,

                "skus" => $productSkus,

                "tags" => $productTags,

                "gallary_images" => $productGalleryImages,

                "related_products" => $productRelatedProducts,
                "up_sales" => $productUpSales,
                "cross_sales" => $productCrossSales,
                "shipping_methods" => $productShippingMethods,
            ];
        }

        $seller = null;
        if (isset($this->seller)) {
            $selesMan = $this->seller;
            $seller = [
                "id" => $selesMan->id,
                "first_name" => $selesMan->first_name,
                "last_name" => $selesMan->last_name,
                "username" => $selesMan->username,
                "photo" => $selesMan->photo,
                "role_id" => $selesMan->role_id,
                "mobile_verified_at" => $selesMan->mobile_verified_at,
                "email" => $selesMan->email,
                "is_verified" => $selesMan->is_verified,
                "verify_code" => $selesMan->verify_code,
                "email_verified_at" => $selesMan->email_verified_at,
                "notification_preference" => $selesMan->notification_preference,
                "is_active" => $selesMan->is_active,
                "avatar" => $selesMan->avatar,
                "slug" => $selesMan->slug,
                "phone" => $selesMan->phone,
                "date_of_birth" => $selesMan->date_of_birth,
                "description" => $selesMan->description,
                "secret_login" => $selesMan->secret_login,
                "lang_code" => $selesMan->lang_code,
                "currency_id" => $selesMan->currency_id,
                "currency_code" => $selesMan->currency_code,
                "created_at" => $selesMan->created_at,
                "updated_at" => $selesMan->updated_at,
                "others" => $selesMan->others,
                "bkash_number" => $selesMan->bkash_number,
                "name" => $selesMan->name,
            ];
        }

        $reviews = [];
        if (isset($goods->reviews)) {
            $reviews = $goods->reviews;
        }

        $skus = [];
        if (isset($goods->skus)) {
            foreach ($goods->skus as $sku) {
                $skuProductVariations = [];
                if(isset($sku->product_variations)){
                    foreach ($sku->product_variations as $skuProVar) {
                        $skuProductVariations[] = [
                            "id" => $skuProVar->id,
                            "product_id" => $skuProVar->product_id,
                            "product_sku_id" => $skuProVar->product_sku_id,
                            "attribute_id" => $skuProVar->attribute_id,
                            "attribute_value_id" => $skuProVar->attribute_value_id,
                            "created_by" => $skuProVar->created_by,
                            "updated_by" => $skuProVar->updated_by,
                            "created_at" => $skuProVar->created_at,
                            "updated_at" => $skuProVar->updated_at,
                        ];
                    }
                }
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
                    "product_variations" => $skuProductVariations,
                ];
            }
        }


        $hasFlashDeal2= null;
        $deal2 = null;
        if(!empty($this->hasDeal)){
            $deal2 = null;
            $allPdctsPdct = $this;
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

            $hasFlashDeal2 = [
                    "id"=> $allPdctsPdct->hasDeal->id,
                    "flash_deal_id"=> $allPdctsPdct->hasDeal->flash_deal_id,
                    "seller_product_id"=> $allPdctsPdct->hasDeal->seller_product_id,
                    "discount"=> $allPdctsPdct->hasDeal->discount,
                    "discount_type"=> $allPdctsPdct->hasDeal->discount_type,
                    "status"=> $allPdctsPdct->hasDeal->status,
                    "flash_deal" => $deal

            ];
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
            "variantDetails" => $this->variantDetails,
            "MaxSellingPrice" => $this->MaxSellingPrice,
            "hasDeal" => $hasFlashDeal2,
            "rating" => $this->rating,
            "hasDiscount" => $this->hasDiscount,
            "ProductType" => $this->ProductType,
            "flash_deal" => $deal2,
            "product" => $product,
            "seller" => $seller,
            "reviews" => $reviews,
            "skus" => $skus,
        ];
    }
}
