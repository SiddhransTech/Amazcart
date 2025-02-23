<?php

namespace Modules\SupportTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class SupportTicketFile extends Model
{
    protected $guarded = [];

 protected $casts = [
        "id" => "integer",
        "attachment_type" => "string",
        "attachment_id" => "integer",
        "name" => "string",
        "url" => "string",
        "type" => "string",

    ];

    public function attachment()
    {
    	return $this->morphTo();
    }
}
