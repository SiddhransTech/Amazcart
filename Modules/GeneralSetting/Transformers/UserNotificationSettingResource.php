<?php

namespace Modules\GeneralSetting\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserNotificationSettingResource extends JsonResource
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
            "user_id" => $this->user_id,
            "notification_setting_id" => $this->notification_setting_id,
            "type" => $this->type,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "notification_setting" => new  NotificationSettingResource($this->notification_setting)
        ];
    }
}
