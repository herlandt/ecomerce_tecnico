<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- ¡Añade esto!

class Product extends Model
{
    use HasFactory;

    // --- RELACIONES ---
    public function category() { return $this->belongsTo(Category::class); }
    public function platform() { return $this->belongsTo(Platform::class); }
    public function game() { return $this->belongsTo(Game::class); }
    public function orders() { return $this->belongsToMany(Order::class, 'order_product'); }

    // ¡NUEVA RELACIÓN! Un producto tiene muchos códigos.
    public function activationCodes()
    {
        return $this->hasMany(ActivationCode::class);
    }

    // --- ATRIBUTO CALCULADO PARA EL STOCK ---
    // Este es el "campo virtual" para el stock.
    protected function stock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->activationCodes()->where('is_sold', false)->count(),
        );
    }
}