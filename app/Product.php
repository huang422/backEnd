<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'types_id', 'img', 'title', 'text', 'sort',
    ];

    public function product_imgs(){
        return $this->belongsTo('App\ProductTypes','types_id');
    }
}
