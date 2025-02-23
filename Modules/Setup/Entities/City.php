<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];
    protected $guarded = ['id'];

    protected $casts  = [
        "id" => "integer",
        "state_id" => "integer",
        "name" => "string",
        "status" => "integer",

    ];

    public function state(){
        return $this->belongsTo(State::class,'state_id','id');
    }

}
