<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productDetail extends Model
{
    use HasFactory;
    protected $table = 'product_detail';
    public $timestamps = false;
    protected $fillable = ['id', 'product_id', 'color', 'size', 'quantity'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
