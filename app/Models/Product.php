<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Category;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    public $timestamps = false;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
     public function cart()
    {
        return $this->belongsToMany(Cart::class)->withPivot('size');
    }
    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class);
    }
    public function images()
    {
        return $this->hasMany(Images::class);
    }
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
   
    
    
}
