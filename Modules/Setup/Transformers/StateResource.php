<?php

namespace Modules\Setup\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class StateResource extends JsonResource
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
            "country_id" => $this->country_id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "torod_country_id" => !empty($this->torod_country_id ) ? $this->torod_country_id:null,
            "torod_state_id" => !empty($this->torod_country_id) ? $this->torod_state_id:null,
        ];
    }
}
