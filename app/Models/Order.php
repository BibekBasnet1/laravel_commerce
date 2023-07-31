<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_details' => 'array',
        'user_id',
        'total',

    ];

    // a order can have more than one order details 
    public function order_details()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

}
