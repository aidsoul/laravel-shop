<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * @author aidsoul <work-aidsoul@outlook.com>
 */
class GalleryImage extends Model {

    protected $fillable = [
        'id',
        'url'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

}