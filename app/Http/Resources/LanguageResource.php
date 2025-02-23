<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>  $this->id,
            "code"=>  $this->code,
            "name"=>  $this->name,
            "native"=>  $this->native,
            "rtl"=>  $this->rtl == 1 ? true:false,
            "status"=> $this->status,
            "json_exist"=>  $this->json_exist,
            "created_at"=> $this->created_at,
            "updated_at"=>  $this->updated_at,
        ];
    }
}
