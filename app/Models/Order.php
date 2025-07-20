<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_price',
    ];

    // ... tu método de relación 'products()' debería estar aquí ...
    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class, 'order_product')
                    ->withPivot('quantity', 'price', 'activation_code_id');
    }
}