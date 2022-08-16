<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'first_name',
        'last_name',
        'middle_name',
        'price',
        'quantity',
        'cost',
    ];

    /**
     * Связь «элемент принадлежит» таблицы `order_item` с таблицей `products`
     */
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
