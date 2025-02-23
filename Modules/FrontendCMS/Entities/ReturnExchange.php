<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class ReturnExchange extends Model
{
    use HasFactory , HasTranslations;

    protected $guarded = ['id'];

    public $translatable = ['mainTitle','returnTitle','exchangeTitle','returnDescription','exchangeDescription'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
}
