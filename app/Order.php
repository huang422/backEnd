<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'recipient_name', 'recipient_phone', 'recipient_address', 'shipment_time', 'total_price', 'shipment_status', 'payment_status',
    ];

    // public function news_imgs(){
    //     return $this->hasMany('App\NewsImgs')->orderby('sort','desc');
    // }
}
