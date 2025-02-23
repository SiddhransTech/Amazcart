<?php

namespace Modules\FrontendCMS\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\GST\Entities\GstTax;
use Spatie\Translatable\HasTranslations;

class Pricing extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = ['id'];
    public $translatable = ['name'];
    protected $appends = ['translateName'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
    public function getTranslateNameAttribute(){
        return $this->attributes['name'];
    }

    public function vat()
    {
        return $this->belongsTo(GstTax::class,'gst_tax_id');
    }
}
