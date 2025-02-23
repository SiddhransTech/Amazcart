<?php

namespace Modules\GeneralSetting\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
                "id" => $this->id,
                "title" => $this->title,
                "created_at" => $this->created_at,
                "order" => $this->order,
        ];
    }
}
