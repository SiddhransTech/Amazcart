<?php

namespace App\Http\Resources\Api\v1\Brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            "name" => $this->name,
            "logo" => $this->logo,
            "file_dropbox" => $this->file_dropbox,
            "description" => $this->description,
            "link" => $this->link,
            "status" => $this->status,
            "featured" => $this->featured,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "sort_id" => $this->sort_id,
            "total_sale" => $this->total_sale,
            "avg_rating" => $this->avg_rating,
            "slug" => $this->slug,
            "created_by" => $this->created_by,
            "updated_by" => $this->updated_by,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
