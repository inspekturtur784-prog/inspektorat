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
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo">
                <span>Admin Inspektorat</span>
            </a>
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <span class="admin-nav-label">Profil</span>
                <a href="{{ route('admin.pengaturan.edit') }}" class="admin-nav-sub {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                    Tentang Inspektorat
                </a>
                <a href="{{ route('admin.pengaturan.edit') }}#visi-misi" class="admin-nav-sub">
                    Visi & Misi
                </a>
                <a href="{{ route('admin.tugasfungsi.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.tugasfungsi.*') ? 'active' : '' }}">
                    Tugas & Fungsi
                </a>
                <a href="{{ route('admin.struktur.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.struktur.*') ? 'active' : '' }}">
                    Struktur Organisasi
                </a>
                <a href="{{ route('admin.pegawai.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.pegawai.*') ? 'active' : '' }}">
                    Data Pegawai
                </a>
                <a href="{{ route('admin.galeri.index') }}" class="admin-nav-sub {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                    Galeri
                </a>

                <span class="admin-nav-label">Konten Lain</span>
                <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                    Artikel / Informasi
                </a>
                <a href="{{ route('admin.pesan.index') }}" class="{{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}" style="display:flex;justify-content:space-between;align-items:center;">
                    <span>Pesan Masuk</span>
                    @php $belumDibaca = \App\Models\Pesan::where('is_read', false)->count(); @endphp
                    @if ($belumDibaca > 0)
                        <span class="admin-nav-badge">{{ $belumDibaca }}</span>
                    @endif
                </a>
                {{-- Tambahkan menu admin lain di sini: Pedoman, Layanan, Publikasi, dst. --}}
            </nav>

            <div class="admin-sidebar-footer">
                <div class="admin-user">
                    <span class="admin-user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <span class="admin-user-email">{{ auth()->user()->email ?? '' }}</span>
                </div>
                <a href="{{ route('admin.password.edit') }}" class="admin-sidebar-link">Ganti Kata Sandi</a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="admin-sidebar-link admin-logout-btn">Keluar</button>
                </form>
            </div>
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