<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RefundReason extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "refund_reasons";
    protected $guarded = ["id"];
    protected $appends = ['translateReason'];
    public $translatable = ['reason'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
    public function getTranslateReasonAttribute(){
        return $this->attributes['reason'];
    }
}
