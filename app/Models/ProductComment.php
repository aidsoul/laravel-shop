<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @author aidsoul <work-aidsoul@outlook.com>
 */
class ProductComment extends Model {

    protected $fillable = [
        'id',
        'text',
        'status',
        'user_id',
        'product_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}