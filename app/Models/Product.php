<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory,softDeletes;

    protected $fillable = [
        'name',
        'price',
        'user_id',
        'category_id',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // a product can contain many carts
    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    // wishlist will be of products so it belongs to product class 
    public function wishlists()
    {
        return $this->belongsTo(Product::class);
    }

    // has many stocks
    public function stocks()
    {
        return $this->hasOne(Stock::class);
    }
    

    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }

    // logic for deleting the image 
    protected static function boot()
    {
        parent::boot();

        // Listen for the "deleting" event
        static::deleting(function ($product) {
            // Delete the associated image from storage if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Delete the associated image from storage
            // Storage::disk('public')->delete($product->image);
        });
    }

}


