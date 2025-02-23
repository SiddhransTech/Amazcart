<?php

namespace App\Http\Resources\Api\v1\SupportTicket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportTicketCategoryResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            "id"=> $this->id,
            "name"=> $this->name,
            "status"=> $this->status,
            "created_at"=> $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
