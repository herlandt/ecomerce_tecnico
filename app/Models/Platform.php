<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
   public function products()
{
    return $this->hasMany(Product::class);
}
}
