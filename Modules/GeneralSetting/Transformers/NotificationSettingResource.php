<?php

namespace Modules\GeneralSetting\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationSettingResource extends JsonResource
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
            "event" => $this->event,
            "slug" => $this->slug,
            "delivery_process_id" => $this->delivery_process_id,
            "type" => $this->type,
            "message" => $this->message,
            "admin_msg" => $this->admin_msg,
            "user_access_status" => $this->user_access_status,
            "seller_access_status" => $this->seller_access_status,
            "admin_access_status" => $this->admin_access_status,
            "staff_access_status" => $this->staff_access_status,
            "module" => $this->module,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "translateevent" => $this->message,
            "Translatemessage" => $this->message,
            "Translateadminmessage" => $this->message,
        ];
    }
}
