<?php

namespace Modules\Setup\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\INTShipping\Entities\Continent;
use Spatie\Translatable\HasTranslations;

class Country extends Model
{
    use HasTranslations;


    protected $table = 'countries';

    public $translatable = ['name'];
    protected $guarded = ['id'];
    protected $casts  = [
        "id" => "integer",
        "code" => "string",
        "name" => "string",
        "phonecode" => "string",
        "flag" => "string",
        "status" => "integer",
    ];

    public function continent(){
        return $this->belongsTo(Continent::class,'continent_id','id');
    }
    public function states(){
        return $this->hasMany(State::class,'country_id','id')->orderBy('name');
    }

    public function cities(){
        return $this->hasManyThrough(City::class, State::class);
    }
}
