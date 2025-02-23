<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\v1\Product\RelatedProductResource;
use App\Http\Resources\Api\v1\Product\UpSalesProductResource;
use App\Http\Resources\Api\v1\Product\CrossSalesProductResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "product_name" => $this->product_name,
            "product_type" => $this->product_type,
            "variant_sku_prefix" => $this->variant_sku_prefix,
            "unit_type_id" => $this->unit_type_id,
            "brand_id" => $this->brand_id,
            "thumbnail_image_source" => $this->thumbnail_image_source,
            "media_ids" => $this->media_ids,
            "barcode_type" => $this->barcode_type,
            "model_number" =>$this->model_number,
            "shipping_type" => $this->shipping_type,
            "shipping_cost" => $this->shipping_cost,
            "discount_type" => $this->discount_type,
            "discount" => $this->discount,
            "tax_type" => $this->tax_type,
            "gst_group_id" => $this->gst_group_id,
            "tax_id" => $this->tax_id,
            "tax" => $this->tax,
            "pdf" => $this->pdf,
            "video_provider" => $this->video_provider,
            "video_link" => $this->video_link,
            "description" =>$this->description,
            "specification" =>$this->specification,
            "minimum_order_qty" => $this->minimum_order_qty,
            "max_order_qty" => $this->max_order_qty,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_image" => $this->meta_image,
            "is_physical" => $this->is_physical,
            "is_approved" => $this->is_approved,
            "status" => $this->status,
            "display_in_details" => $this->display_in_details,
            "requested_by" => $this->requested_by,
            "created_by" => $this->created_by,
            "slug" => $this->slug,
            "updated_by" => $this->updated_by,
            "stock_manage" => $this->stock_manage,
            "subtitle_1" => $this->subtitle_1,
            "subtitle_2" => $this->subtitle_2,
            "shipping_methods" => !empty($this->shippingMethods) ? ShippingMethodResource::collection($this->shippingMethods):null,
            "up_sales" => UpSalesProductResource::collection($this->upSales),
            "cross_sales" => CrossSalesProductResource::collection($this->crossSales),
            "related_products" => RelatedProductResource::collection($this->relatedProducts),
            "gallary_images"=> $this->gallary_images,
            "brand" => new FeaturedBrandResource($this->brand),
        ];
    }
}
