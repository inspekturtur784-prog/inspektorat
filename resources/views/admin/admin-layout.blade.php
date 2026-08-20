<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Inspektorat Kota Mojokerto</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo">
                <span>Admin Inspektorat</span>
            </div>
            <nav>
                <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    Artikel / Informasi
                </a>
                <a href="{{ route('admin.pegawai.index') }}" class="{{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                    Data Pegawai
                </a>
                <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                    Galeri
                </a>
                {{-- Tambahkan menu admin lain di sini: Pedoman, Layanan, Publikasi, dst. --}}
            </nav>
        </aside>

        <main class="admin-main">
            @if (session('status'))
                <div class="admin-alert">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>