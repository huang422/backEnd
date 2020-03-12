<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'types_id', 'img', 'title', 'text', 'sort', 'price',
    ];

    public function product_types(){
        return $this->belongsTo('App\ProductTypes','types_id'); //(model, foreign_key,primary_key)
    }
}
