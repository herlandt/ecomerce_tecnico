<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ActivationCode;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Este es el método que se ejecutará desde la ruta que definimos
    public function index()
    {
        // 1. Busca todos los productos en la base de datos
        $products = Product::all();

        // 2. Devuelve una vista llamada 'products.index' y le pasa la variable $products
        return view('products.index', [
            'products' => $products
        ]);
    }
  // ... en ProductController.php

public function show(Product $product)
{
    // Cargamos el producto junto con sus relaciones para ser eficientes
    $product->load('category', 'platform', 'game');

    return view('products.show', [
        'product' => $product
    ]);
}
public function byCategory(\App\Models\Category $category)
{
    // Reutilizaremos la vista de la lista de productos,
    // pero le pasaremos solo los productos que pertenecen a esta categoría.
    return view('products.index', [
        'products' => $category->products, // Carga solo los productos de esta categoría
        'currentCategory' => $category    // Enviamos la categoría actual para mostrar su nombre
    ]);
}
// --- ¡NUEVO MÉTODO PARA AÑADIR AL CARRITO! ---
public function addToCart(Request $request, \App\Models\Product $product)
{
    // 1. Obtenemos el carrito actual de la sesión. Si no existe, creamos un array vacío.
    $cart = $request->session()->get('cart', []);

    // 2. Revisamos si el producto ya está en el carrito.
    if (isset($cart[$product->id])) {
        // Si ya está, simplemente incrementamos la cantidad.
        $cart[$product->id]['quantity']++;
    } else {
        // Si no está, lo añadimos al carrito con cantidad 1.
        $cart[$product->id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image_url" => $product->image_url
        ];
    }

    // 3. Guardamos el carrito (ya sea nuevo o actualizado) de vuelta en la sesión.
    $request->session()->put('cart', $cart);

    // 4. Redirigimos al usuario a la página anterior con un mensaje de éxito.
    return redirect()->back()->with('success', '¡Producto añadido al carrito!');
}
// --- ¡NUEVO MÉTODO PARA VER EL CARRITO! ---
public function viewCart(Request $request)
{
    // 1. Obtenemos el carrito de la sesión.
    $cart = $request->session()->get('cart', []);

    // 2. Calculamos el precio total.
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // 3. Devolvemos la vista del carrito y le pasamos los productos y el total.
    return view('cart.index', [
        'cartItems' => $cart,
        'total' => $total
    ]);
}// ... en app/Http/Controllers/ProductController.php

// ... métodos anteriores ...

// --- ¡NUEVO MÉTODO PARA ELIMINAR DEL CARRITO! ---
public function removeFromCart(Request $request, \App\Models\Product $product)
{
    // 1. Obtenemos el carrito actual de la sesión.
    $cart = $request->session()->get('cart', []);

    // 2. Revisamos si el producto realmente existe en el carrito.
    if (isset($cart[$product->id])) {
        // Si existe, lo eliminamos del array del carrito.
        unset($cart[$product->id]);
    }

    // 3. Guardamos el carrito actualizado de vuelta en la sesión.
    $request->session()->put('cart', $cart);

    // 4. Redirigimos al usuario de vuelta a la página del carrito con un mensaje.
    return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
}
// --- ¡NUEVO MÉTODO PARA BUSCAR PRODUCTOS! ---
public function search(Request $request)
{
    // 1. Obtenemos el término de búsqueda de la URL.
    $query = $request->input('query');

    // 2. Buscamos en la base de datos.
    // Buscaremos productos donde el 'name' O la 'description' contengan el texto buscado.
    $products = \App\Models\Product::where('name', 'LIKE', "%{$query}%")
                                    ->orWhere('description', 'LIKE', "%{$query}%")
                                    ->get();

    // 3. Devolvemos la misma vista de la lista de productos, pero con los resultados filtrados.
    return view('products.index', [
        'products' => $products,
        'searchQuery' => $query // Enviamos el término de búsqueda para mostrarlo en el título
    ]);
}
// --- ¡NUEVO MÉTODO PARA PROCESAR EL PAGO! ---
public function checkout(Request $request)
{
    $cart = $request->session()->get('cart', []);
    if (empty($cart)) {
        return redirect()->route('products.index')->with('error', 'Tu carrito está vacío.');
    }

    // Usamos una transacción para asegurar que todas las operaciones se completen o ninguna lo haga.
    // Esto evita vender un producto si no hay códigos, por ejemplo.
    try {
        DB::beginTransaction();

        // 1. Crear la orden principal
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
        ]);

        $purchasedItems = [];

        // 2. Procesar cada producto del carrito
        foreach ($cart as $productId => $item) {
            // Buscamos un código de activación disponible para este producto
            $activationCode = ActivationCode::where('product_id', $productId)
                                            ->where('is_sold', false)
                                            ->first();

            // Si NO encontramos un código, cancelamos toda la compra.
            if (!$activationCode) {
                throw new \Exception('Lo sentimos, no hay stock disponible para ' . $item['name']);
            }

            // 3. Adjuntamos el producto a la orden con su código
            $order->products()->attach($productId, [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'activation_code_id' => $activationCode->id,
            ]);

            // 4. Marcamos el código como vendido
            $activationCode->update(['is_sold' => true]);

            // Guardamos la información para el correo
            $purchasedItems[] = [
                'name' => $item['name'],
                'code' => $activationCode->code,
            ];
        }

        // Si todo salió bien, confirmamos los cambios en la base de datos
        DB::commit();

        // 5. Limpiar el carrito
        $request->session()->forget('cart');

        // --- AQUÍ IRÁ LA LÓGICA PARA ENVIAR EL CORREO ---
        // Por ahora, solo redirigimos con un mensaje de éxito.

        return redirect()->route('products.index')->with('success', '¡Compra realizada con éxito! Revisa tu correo para ver tus códigos.');

    } catch (\Exception $e) {
        // Si algo falló, revertimos todos los cambios
        DB::rollBack();
        return redirect()->route('cart.index')->with('error', $e->getMessage());
    }
}
}