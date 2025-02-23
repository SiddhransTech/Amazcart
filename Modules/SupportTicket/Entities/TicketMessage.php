<?php

namespace Modules\SupportTicket\Entities;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TicketMessage extends Model
{
    protected $table = 'ticket_messages';
    protected $guarded = [];

    protected $casts =[
                    'id' => "integer",
                    'ticket_id' => "integer",
                    'text' => "string",
                    'user_id' => "integer",
                    'type' => "integer",
                ];


    public function user()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }
    public function attachFiles()
    {
    	return $this->morphMany(SupportTicketFile::class,'attachment');
    }
     public function attachMsgFile(){
        return $this->hasMany(TicketMessageFile::class,'message_id');
    }
}
