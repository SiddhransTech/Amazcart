<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ToppicksResource;
class SearchCategoryRespose extends JsonResource
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
               "slug" => $this->slug,
               "parent_id" => $this->parent_id,
               "depth_level" => $this->depth_level,
               "icon" => $this->icon,
               "searchable" => $this->searchable,
               "status" => $this->status,
               "total_sale" => $this->total_sale,
               "avg_rating" => $this->avg_rating,
               "commission_rate" => $this->commission_rate,
               "created_at" => $this->created_at,
               "updated_at" => $this->updated_at,
               "AllProducts" => ToppicksResource::collection($this->AllProducts),
        ];
    }
}
