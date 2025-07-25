@extends('layouts.app')

@section('title', 'Nuestros Productos')

@section('content')
    @if (isset($searchQuery))
        <h1>Resultados para: "{{ $searchQuery }}"</h1>
    @elseif (isset($currentCategory))
        <h1>{{ $currentCategory->name }}</h1>
    @else
        <h1>Nuestros Productos</h1>
    @endif
   
    <div class="product-grid">
        @forelse ($products as $product)
            <a href="{{ route('products.show', $product) }}">
                <div class="product-card">
                    <img src="{{ $product->image_url ?? 'https://via.placeholder.com/300x200' }}" alt="Imagen de {{ $product->name }}">
                    <div class="product-card-body">
                        <h3 class="product-card-title">{{ $product->name }}</h3>
                        <p class="product-card-price">${{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
            </a>
        @empty
            <p>No hay productos disponibles en este momento.</p>
        @endforelse
    </div>

@endsection