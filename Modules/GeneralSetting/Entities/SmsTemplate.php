<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class SmsTemplate extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];
    public $translatable = ['subject','value'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    public function templateType(){
        return $this->belongsTo(SmsTemplateType::class, 'type_id','id');
    }

    public function relatable()
    {
        return $this->morphTo();
    }

}
