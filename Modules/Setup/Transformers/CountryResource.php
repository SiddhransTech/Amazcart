<?php

namespace Modules\Setup\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            "code" => $this->code,
            "name" => $this->name,
            "phonecode" => $this->phonecode,
            "flag" => $this->flag,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "torod_country_id" => !empty($this->torod_country_id) ? $this->torod_country_id:null
        ];
    }
}
