<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $customer = null;
        if (isset($this->customer)) {
            $customer = $this->customer;
        }

        $packages = [];
        if (isset($this->packages)) {
            foreach ($this->packages as $package) {
                /* Processes */
                $packageProcesses = [];
                if ($package->processes) {
                    foreach ($package->processes as $pkgProcess) {
                        $packageProcesses[] = $pkgProcess;
                    }
                }

                $packageSeller = $package->seller;

                /* Delivery States */
                $packageDeliveryStates = $package->delivery_states;

                $packageProducts = [];
                if (isset($package->products)) {
                    foreach ($package->products as $pkgProduct) {


                        $pkgProductSellerProductSku = null;
                        if (isset($pkgProduct->seller_product_sku)) {
                            $pkgPdctSlrPdctSku = $pkgProduct->seller_product_sku;

                            /* Product */
                            $pkgPdctSlrPdctSkuProduct = null;
                            if (isset($pkgPdctSlrPdctSku->product)) {
                                $pkgPdctSlrPdctSkuPdct = $pkgPdctSlrPdctSku->product;

                                $pkgPdctSlrPdctSkuPdctProduct = null;
                                if (isset($pkgPdctSlrPdctSkuPdct->product)) {
                                    $pkgPdctSlrPdctSkuPdctPdct = $pkgPdctSlrPdctSkuPdct->product;




                                    $pkgPdctSlrPdctSkuPdctProduct = [
                                        "id" => $pkgPdctSlrPdctSkuPdctPdct->id,
                                        "product_name" => $pkgPdctSlrPdctSkuPdctPdct->product_name,
                                        "product_type" => $pkgPdctSlrPdctSkuPdctPdct->product_type,
                                        "variant_sku_prefix" => $pkgPdctSlrPdctSkuPdctPdct->variant_sku_prefix,
                                        "unit_type_id" => $pkgPdctSlrPdctSkuPdctPdct->unit_type_id,
                                        "brand_id" => $pkgPdctSlrPdctSkuPdctPdct->brand_id,
                                        "thumbnail_image_source" => $pkgPdctSlrPdctSkuPdctPdct->thumbnail_image_source,
                                        "media_ids" => $pkgPdctSlrPdctSkuPdctPdct->media_ids,
                                        "barcode_type" => $pkgPdctSlrPdctSkuPdctPdct->barcode_type,
                                        "model_number" => $pkgPdctSlrPdctSkuPdctPdct->model_number,
                                        "shipping_type" => $pkgPdctSlrPdctSkuPdctPdct->shipping_type,
                                        "shipping_cost" => $pkgPdctSlrPdctSkuPdctPdct->shipping_cost,
                                        "discount_type" => $pkgPdctSlrPdctSkuPdctPdct->discount_type,
                                        "discount" => $pkgPdctSlrPdctSkuPdctPdct->discount,
                                        "tax_type" => $pkgPdctSlrPdctSkuPdctPdct->tax_type,
                                        "gst_group_id" => $pkgPdctSlrPdctSkuPdctPdct->gst_group_id,
                                        "tax_id" => $pkgPdctSlrPdctSkuPdctPdct->tax_id,
                                        "tax" => $pkgPdctSlrPdctSkuPdctPdct->tax,
                                        "pdf" => $pkgPdctSlrPdctSkuPdctPdct->pdf,
                                        "video_provider" => $pkgPdctSlrPdctSkuPdctPdct->video_provider,
                                        "video_link" => $pkgPdctSlrPdctSkuPdctPdct->video_link,
                                        "description" => $pkgPdctSlrPdctSkuPdctPdct->description,
                                        "specification" => $pkgPdctSlrPdctSkuPdctPdct->specification,
                                        "minimum_order_qty" => $pkgPdctSlrPdctSkuPdctPdct->minimum_order_qty,
                                        "max_order_qty" => $pkgPdctSlrPdctSkuPdctPdct->max_order_qty,
                                        "meta_title" => $pkgPdctSlrPdctSkuPdctPdct->meta_title,
                                        "meta_description" => $pkgPdctSlrPdctSkuPdctPdct->meta_description,
                                        "meta_image" => $pkgPdctSlrPdctSkuPdctPdct->meta_image,
                                        "is_physical" => $pkgPdctSlrPdctSkuPdctPdct->is_physical,
                                        "is_approved" => $pkgPdctSlrPdctSkuPdctPdct->is_approved,
                                        "status" => $pkgPdctSlrPdctSkuPdctPdct->status,
                                        "display_in_details" => $pkgPdctSlrPdctSkuPdctPdct->display_in_details,
                                        "requested_by" => $pkgPdctSlrPdctSkuPdctPdct->requested_by,
                                        "created_by" => $pkgPdctSlrPdctSkuPdctPdct->created_by,
                                        "slug" => $pkgPdctSlrPdctSkuPdctPdct->slug,
                                        "stock_manage" => $pkgPdctSlrPdctSkuPdctPdct->stock_manage,
                                        "subtitle_1" => $pkgPdctSlrPdctSkuPdctPdct->subtitle_1,
                                        "subtitle_2" => $pkgPdctSlrPdctSkuPdctPdct->subtitle_2,
                                        "updated_by" => $pkgPdctSlrPdctSkuPdctPdct->updated_by,
                                        "created_at" => $pkgPdctSlrPdctSkuPdctPdct->created_at,
                                        "updated_at" => $pkgPdctSlrPdctSkuPdctPdct->updated_at,

                                    ];
                                }

                                $pkgPdctSlrPdctSkuPdctSkus = $pkgPdctSlrPdctSkuPdct->skus;

                                $pkgPdctSlrPdctSkuProduct = [
                                    "id" => $pkgPdctSlrPdctSkuPdct->id,
                                    "user_id" => $pkgPdctSlrPdctSkuPdct->user_id,
                                    "product_id" => $pkgPdctSlrPdctSkuPdct->product_id,
                                    "tax" => $pkgPdctSlrPdctSkuPdct->tax,
                                    "tax_type" => $pkgPdctSlrPdctSkuPdct->tax_type,
                                    "discount" => $pkgPdctSlrPdctSkuPdct->discount,
                                    "discount_type" => $pkgPdctSlrPdctSkuPdct->discount_type,
                                    "discount_start_date" => $pkgPdctSlrPdctSkuPdct->discount_start_date,
                                    "discount_end_date" => $pkgPdctSlrPdctSkuPdct->discount_end_date,
                                    "product_name" => $pkgPdctSlrPdctSkuPdct->product_name,
                                    "slug" => $pkgPdctSlrPdctSkuPdct->slug,
                                    "thum_img" => $pkgPdctSlrPdctSkuPdct->thum_img,
                                    "status" => $pkgPdctSlrPdctSkuPdct->status,
                                    "stock_manage" => $pkgPdctSlrPdctSkuPdct->stock_manage,
                                    "is_approved" => $pkgPdctSlrPdctSkuPdct->is_approved,
                                    "min_sell_price" => $pkgPdctSlrPdctSkuPdct->min_sell_price,
                                    "max_sell_price" => $pkgPdctSlrPdctSkuPdct->max_sell_price,
                                    "total_sale" => $pkgPdctSlrPdctSkuPdct->total_sale,
                                    "avg_rating" => $pkgPdctSlrPdctSkuPdct->avg_rating,
                                    "recent_view" => $pkgPdctSlrPdctSkuPdct->recent_view,
                                    "subtitle_1" => $pkgPdctSlrPdctSkuPdct->subtitle_1,
                                    "subtitle_2" => $pkgPdctSlrPdctSkuPdct->subtitle_2,
                                    "created_at" => $pkgPdctSlrPdctSkuPdct->created_at,
                                    "updated_at" => $pkgPdctSlrPdctSkuPdct->updated_at,
                                    "variantDetails" => $pkgPdctSlrPdctSkuPdct->variantDetails,
                                    "MaxSellingPrice" => $pkgPdctSlrPdctSkuPdct->MaxSellingPrice,
                                    "hasDeal" => $pkgPdctSlrPdctSkuPdct->hasDeal,
                                    "rating" => $pkgPdctSlrPdctSkuPdct->rating,
                                    "hasDiscount" => $pkgPdctSlrPdctSkuPdct->hasDiscount,
                                    "ProductType" => $pkgPdctSlrPdctSkuPdct->ProductType,
                                    "flash_deal" => $pkgPdctSlrPdctSkuPdct->flash_deal,



                                    "product" => $pkgPdctSlrPdctSkuPdctProduct,



                                    "skus" => $pkgPdctSlrPdctSkuPdctSkus,
                                    "reviews" => $pkgPdctSlrPdctSkuPdct->reviews,
                                ];
                            }

                            $pkgPdctSlrPdctSkuPdctVariations = [];
                            if (isset($pkgPdctSlrPdctSku->product_variations)) {
                                foreach ($pkgPdctSlrPdctSku->product_variations as $productVariation) {
                                    $productVariationAttribute = $productVariation->attribute;
                                    foreach (json_decode($productVariationAttribute->name, true) as $pdctVrntAttrNm) {
                                        $pdctVrntAttrName = $pdctVrntAttrNm;
                                    }
                                    $pkgPdctSlrPdctSkuPdctVariations[] = [
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

                            $pkgPdctSlrPdctSkuSku = $pkgPdctSlrPdctSku->sku;

                            $pkgProductSellerProductSku = [
                                "id" => $pkgPdctSlrPdctSku->id,
                                "user_id" => $pkgPdctSlrPdctSku->user_id,
                                "product_id" => $pkgPdctSlrPdctSku->product_id,
                                "product_sku_id" => $pkgPdctSlrPdctSku->product_sku_id,
                                "product_stock" => $pkgPdctSlrPdctSku->product_stock,
                                "purchase_price" => $pkgPdctSlrPdctSku->purchase_price,
                                "selling_price" => $pkgPdctSlrPdctSku->selling_price,
                                "status" => $pkgPdctSlrPdctSku->status,
                                "created_at" => $pkgPdctSlrPdctSku->created_at,
                                "updated_at" => $pkgPdctSlrPdctSku->updated_at,
                                "product" => $pkgPdctSlrPdctSkuProduct,
                                "product_variations" => $pkgPdctSlrPdctSkuPdctVariations,
                                "sku" => $pkgPdctSlrPdctSkuSku,
                            ];
                        }

                        $packageProducts[] = [
                            "id" => $pkgProduct->id,
                            "package_id" => $pkgProduct->package_id,
                            "type" => $pkgProduct->type,
                            "product_sku_id" => $pkgProduct->product_sku_id,
                            "qty" => $pkgProduct->qty,
                            "price" => $pkgProduct->price,
                            "total_price" => $pkgProduct->total_price,
                            "tax_amount" => $pkgProduct->tax_amount,
                            "created_at" => $pkgProduct->created_at,
                            "updated_at" => $pkgProduct->updated_at,
                            "seller_product_sku" => $pkgProductSellerProductSku,
                            "gift_card" => $pkgProduct->gift_card,
                        ];
                    }
                }
                $packageGstTaxes = $package->gst_taxes;

                $packages[] = [
                    "id" => $package->id,
                    "order_id" => $package->order_id,
                    "carrier_order_id" => $package->carrier_order_id,
                    "seller_id" => $package->seller_id,
                    "package_code" => $package->package_code,
                    "number_of_product" => $package->number_of_product,
                    "shipping_cost" => $package->shipping_cost,
                    "shipping_date" => $package->shipping_date,
                    "shipping_method" => $package->shipping_method,
                    "carrier_id" => $package->carrier_id,
                    "shipped_by" => $package->shipped_by,
                    "is_cancelled" => $package->is_canceled,
                    "is_paid" => $package->is_paid,
                    "cancel_reason_id" => $package->cancel_reason_id,
                    "is_reviewed" => $package->is_received,
                    "delivery_status" => $package->delivery_status,
                    "last_updated_by" => $package->last_updated_by,
                    "gst_claimed" => $package->gst_claimed,
                    "tax_amount" => $package->tax_amount,
                    "created_at" => $package->created_at,
                    "updated_at" => $package->updated_at,
                    "carrier_response" => $package->carrier_response,
                    "pickup_point_id" => $package->pickup_point_id,
                    "weight" => $package->weight,
                    "length" => $package->length,
                    "breadth" => $package->breadth,
                    "height" => $package->height,
                    "torod_processing" => $package->torod_processing,
                    "deliveryStateName" => $package->deliveryStateName,
                    "totalGST" => $package->totalGST,
                    "processes" => $packageProcesses,
                    "seller" => $packageSeller,
                    "delivery_states" => $packageDeliveryStates,
                    "products" => $packageProducts,
                    "gst_taxes" => $packageGstTaxes,
                ];
            }
        }

        return [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "order_payment_id" => $this->order_payment_id,
            "order_type" => $this->order_type,
            "order_number" => $this->order_number,
            "payment_type" => $this->payment_type,
            "is_paid" => $this->is_paid,
            "is_confirmed" => $this->is_confirmed,
            "is_completed" => $this->is_completed,
            "is_cancelled" => $this->is_canceled,
            "cancel_reason_id" => $this->cancel_reason_id,
            "customer_email" => $this->customer_email,
            "customer_phone" => $this->customer_phone,
            "customer_shipping_address" => $this->customer_shipping_address,
            "customer_billing_address" => $this->customer_billing_address,
            "number_of_package" => $this->number_of_package,
            "grand_total" => $this->grand_total,
            "sub_total" => $this->sub_total,
            "discount_total" => $this->discount_total,
            "shipping_total" => $this->shipping_total,
            "number_of_item" => $this->number_of_item,
            "order_status" => $this->order_status,
            "tax_amount" => $this->tax_amount,
            "note" => $this->note,
            "delivery_type" => $this->delivery_type,
            "pickup_location_id" => $this->pickup_location_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "is_received" => $this->is_received,
            "customer" => $customer,
            "packages" => $packages,
            "address" => $this->address,
            "shipping_address" => $this->shipping_address,
            "billing_address" => $this->billing_address,
        ];
    }
}
