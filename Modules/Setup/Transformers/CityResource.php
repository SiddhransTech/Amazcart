<?php

namespace Modules\Setup\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "state_id" => $this->state_id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "torod_state_id" => !empty($this->torod_state_id) ? $this->torod_state_id:null,
            "torod_city_id" => !empty($this->torod_city_id) ? $this->torod_city_id:null,
        ];
    }
}
