@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="product-detail-layout">
        <div class="product-detail-image">
             <img src="{{ $product->image_url ?? 'https://via.placeholder.com/400x400' }}" alt="Imagen de {{ $product->name }}">
        </div>

        <div class="product-detail-info">
            <h1>{{ $product->name }}</h1>
            <p style="font-size: 2rem; font-weight: bold; color: var(--primary-color);">${{ number_format($product->price, 2) }}</p>
            
            <div class="product-meta">
                <p><strong>Categoría:</strong> {{ $product->category->name }}</p>
                @if ($product->platform)
                    <p><strong>Plataforma:</strong> {{ $product->platform->name }}</p>
                @endif 
                @if ($product->game)
                    <p><strong>Juego Asociado:</strong> {{ $product->game->name }}</p>
                @endif
            </div>

            <hr>

            <h3>Descripción</h3>
            <p>{{ $product->description }}</p>

          <form action="{{ route('cart.add', $product) }}" method="POST">
    @csrf <button type="submit" style="padding: 1rem 2rem; background-color: var(--primary-color); color: white; border: none; border-radius: 5px; font-size: 1rem; cursor: pointer; margin-top: 1rem;">
        Añadir al Carrito
    </button>
</form>
        </div>
    </div>
@endsection