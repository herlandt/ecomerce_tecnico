@extends('layouts.app')

@section('title', 'Mi Carrito de Compras')

@section('content')
    <h1>Mi Carrito</h1>

    @if (!empty($cartItems))
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color);">
                    <th style="text-align: left; padding: 1rem;">Producto</th>
                    <th style="text-align: center; padding: 1rem;">Cantidad</th>
                    <th style="text-align: right; padding: 1rem;">Precio Unitario</th>
                    <th style="text-align: right; padding: 1rem;">Subtotal</th>
                    <th style="text-align: center; padding: 1rem;">Acción</th> </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $id => $item)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center;">
                                <img src="{{ $item['image_url'] ?? 'https://via.placeholder.com/100x100' }}" alt="{{ $item['name'] }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; margin-right: 1rem;">
                                <span>{{ $item['name'] }}</span>
                            </div>
                        </td>
                        <td style="text-align: center; padding: 1rem;">{{ $item['quantity'] }}</td>
                        <td style="text-align: right; padding: 1rem;">${{ number_format($item['price'], 2) }}</td>
                        <td style="text-align: right; padding: 1rem;">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        
                        <td style="text-align: center; padding: 1rem;">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 1.2rem;">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 2rem;">
            <h2 style="font-size: 2rem;">Total: <span style="color: var(--primary-color);">${{ number_format($total, 2) }}</span></h2>
            <form action="{{ route('cart.checkout') }}" method="POST">
    @csrf
    <button type="submit" style="padding: 1rem 2rem; background-color: var(--primary-color); color: white; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer;">
        Proceder al Pago
    </button>
</form>
        </div>

    @else
        <div style="background-color: var(--card-bg); padding: 2rem; text-align: center; border-radius: 8px;">
            <h2>Tu carrito está vacío.</h2>
            <p>¡Añade algunos productos para empezar!</p>
            <a href="{{ route('products.index') }}" style="display: inline-block; margin-top: 1rem; padding: 0.8rem 1.5rem; background-color: var(--primary-color); color: white; border-radius: 5px;">Ver Productos</a>
        </div>
    @endif
@endsection