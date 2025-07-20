<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // <-- ¡Asegúrate de que esta línea esté!

/*
|--------------------------------------------------------------------------
| Rutas de la Tienda (Públicas)
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category:slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// Rutas del Carrito
Route::post('/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [ProductController::class, 'viewCart'])->name('cart.index');
Route::post('/remove-from-cart/{product}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
// --- ¡NUEVA RUTA PARA PROCESAR EL PAGO! ---
Route::post('/checkout', [ProductController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    // En lugar de una vista de 'dashboard', redirigimos a la tienda.
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';