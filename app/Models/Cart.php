<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;


    // a cart can contain may products

    public function products()
    {
        return $this->hasMany(Product::class);
    }


}








