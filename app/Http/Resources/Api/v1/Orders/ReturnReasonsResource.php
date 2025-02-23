<?php

namespace App\Http\Resources\Api\v1\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnReasonsResource extends JsonResource
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
                "reason" =>  $this->reason,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
                "translateReason" => $this->reason,
       ];
    }
}
