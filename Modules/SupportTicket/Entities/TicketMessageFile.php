<?php

namespace Modules\SupportTicket\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketMessageFile extends Model
{
	protected $table = 'ticket_message_files';
    protected $guarded = [];

    protected $casts = [
        "id" => "integer",
        "attachment_type" => "string",
        "attachment_id" => "integer",
        "name" => "string",
        "url" => "string",
        "type" => "string",

    ];
}
