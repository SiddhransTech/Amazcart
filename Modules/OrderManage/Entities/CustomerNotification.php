<?php

namespace Modules\OrderManage\Entities;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class CustomerNotification extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = ['id'];

    protected $translatable = ['title'];


    protected $hidden = [
        'order_id',
        'customer_id',
        'seller_id',
        'url',
        'description',
        'read_status',
        'super_admin_read_status',
        'updated_at',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id','id');
    }
}
