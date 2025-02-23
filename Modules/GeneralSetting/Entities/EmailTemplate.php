<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class EmailTemplate extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = ['id'];
    public $translatable = ['subject','value'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
    public function email_template_type()
    {
        return $this->belongsTo(EmailTemplateType::class,'type_id','id')->withDefault();
    }
    public function relatable()
    {
        return $this->morphTo();
    }
}
