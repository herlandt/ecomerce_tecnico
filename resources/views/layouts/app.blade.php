<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Tienda Friki')</title>


     

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary-color: #FF19E4; --text-color: #e9e2e0ff; --bg-color: #1B0A2A; --card-bg: #2A1A4A; --border-color: #4A3A6A;
            }
            body { font-family: 'Inter', sans-serif; margin: 0; background-color: var(--bg-color); color: var(--text-color); }
            .container { max-width: 1200px; margin-left: auto; margin-right: auto; padding: 0 2rem; }
            main.container { margin-top: 2rem; margin-bottom: 2rem; }
            a { text-decoration: none; color: var(--primary-color); }
            .navbar { background-color: var(--card-bg); border-bottom: 1px solid var(--border-color); padding: 1rem 0; }
            .navbar-content-wrapper { display: flex; justify-content: space-between; align-items: center; }
            .navbar-brand { font-size: 1.5rem; font-weight: bold; color: var(--text-color); }
            .navbar-links a { color: var(--text-color); margin: 0 1rem; font-weight: 500; }
            .navbar-actions { display: flex; align-items: center; }
            .search-bar { padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--bg-color); color: var(--text-color);}
            .navbar-actions a { margin-left: 1.5rem; }
            .logo-image { max-height: 120px; }
            .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; }
            .product-card { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: transform 0.2s; }
            .product-card:hover { transform: translateY(-5px); }
            .product-card img { width: 100%; height: 200px; object-fit: cover; background-color: #333; }
            .product-card-body { padding: 1rem; }
            .product-card-title { font-size: 1.1rem; font-weight: 700; color: var(--text-color); margin: 0; }
            .product-card-price { font-size: 1.2rem; font-weight: bold; color: var(--primary-color); margin-top: 0.5rem; }
            .product-detail-layout { display: flex; gap: 2rem; background-color: var(--card-bg); padding: 2rem; border-radius: 8px; }
            .product-detail-image img { width: 100%; max-width: 400px; border-radius: 8px; background-color: #333; }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

           <main class="container">
    
  
    @if (session('success'))
        <div style="background-color: #28a745; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #dc3545; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem; text-align: center;">
            {{ session('error') }}
        </div>
    @endif
    
    @yield('content')
</main>
        </div>
    </body>
</html>
