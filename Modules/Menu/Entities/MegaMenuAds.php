<?php

namespace Modules\Menu\Entities;
use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class MegaMenuAds extends Model
{
    use HasFactory , HasTranslations;
    protected $guarded = ['id'];
    public $translatable = ['title','subtitle'];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }
    public function menu_ads_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'menu_ads_image');
    }
}
