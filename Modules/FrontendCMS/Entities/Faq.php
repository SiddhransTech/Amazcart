<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory , HasTranslations;

    protected $guarded = ['id'];
    protected $appends = ['TranslateName','TranslateDescription'];
    public $translatable = ['title','description'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
    public function getTranslateNameAttribute(){
        return $this->attributes['title'];
    }
    public function getTranslateDescriptionAttribute(){
        return $this->attributes['description'];
    }
}
