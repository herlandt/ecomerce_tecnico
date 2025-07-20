<nav class="navbar">
    <div class="container navbar-content-wrapper">
        <a class="navbar-brand" href="{{ route('products.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo Tienda Friki" class="logo-image">
        </a>
        <div class="navbar-links">
            <a href="{{ route('products.index') }}">Inicio</a>
            <a href="{{ route('products.byCategory', 'juegos-digitales') }}">Juegos</a>
            <a href="{{ route('products.byCategory', 'cosmeticos') }}">Cosméticos</a>
            <a href="{{ route('products.byCategory', 'tarjetas-de-regalo') }}">Tarjetas</a>
            <a href="{{ route('products.byCategory', 'accesorios') }}">Accesorios</a>
        </div>
        <div class="navbar-actions">
            <form action="{{ route('products.search') }}" method="GET" style="display: flex;">
                <input type="search" name="query" placeholder="Buscar..." class="search-bar" value="{{ request('query') ?? '' }}">
                <button type="submit" style="background: none; border: none; color: var(--text-color); cursor: pointer; font-size: 1.2rem; margin-left: -2rem;">🔍</button>
            </form>

            <a href="{{ route('cart.index') }}">🛒</a>

            @auth
                <span style="margin-left: 1rem;">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();" 
                       style="margin-left: 1rem;">
                        Salir
                    </a>
                </form>
            @else
                <a href="{{ route('login') }}" style="margin-left: 1rem;">👤 Login</a>
                <a href="{{ route('register') }}" style="margin-left: 1rem;">Registro</a>
            @endauth
        </div>
    </div>
</nav>