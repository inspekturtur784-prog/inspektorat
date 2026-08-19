<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inspektorat Kota Mojokerto')</title>
    <meta name="description" content="@yield('meta_description', 'Website resmi Inspektorat Kota Mojokerto — Zona Integritas menuju wilayah bebas dari korupsi.')">
    <link rel="icon" href="{{ asset('images/logo-mojokerto.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <a href="#konten" class="skip-link">Langsung ke konten</a>

    <header class="site-header">
        <div class="wrap">
            <a href="{{ url('/') }}" class="brand">
                <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo Pemerintah Kota Mojokerto">
                <span class="brand-text">
                    <strong>Inspektorat</strong>
                    <span>Kota Mojokerto</span>
                </span>
            </a>
            <nav class="main-nav" aria-label="Navigasi utama">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ url('/profil') }}">Profil</a>
                <a href="{{ url('/layanan') }}">Layanan</a>
                <a href="{{ url('/berita') }}">Berita</a>
                <a href="{{ url('/kontak') }}" class="nav-cta">Kontak Kami</a>
            </nav>
        </div>
    </header>

    <main id="konten">
        @yield('content')
    </main>

    <footer>
        <div class="wrap">
            <div class="footer-grid">
                <div class="footer-brand">
                    <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo Pemerintah Kota Mojokerto">
                    <div>
                        <strong>Inspektorat Kota Mojokerto</strong>
                        <p>Aparat Pengawasan Intern Pemerintah yang mengawal tata kelola pemerintahan Kota Mojokerto agar bersih, akuntabel, dan bebas dari korupsi.</p>
                    </div>
                </div>
                <div>
                    <h4>Tautan</h4>
                    <ul>
                        <li><a href="{{ url('/profil') }}">Profil Inspektorat</a></li>
                        <li><a href="{{ url('/layanan') }}">Layanan Kami</a></li>
                        <li><a href="{{ url('/berita') }}">Buletin Pengawasan</a></li>
                        <li><a href="{{ url('/skm') }}">Survei Kepuasan Masyarakat</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Kontak</h4>
                    <ul>
                        <li>Jl. Gajah Mada, Kota Mojokerto</li>
                        <li>inspektorat@mojokertokota.go.id</li>
                        <li>(0321) 000-000</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Inspektorat Kota Mojokerto. Zona Integritas — Tolak Gratifikasi.</span>
                <span>Dibangun dengan Laravel</span>
            </div>
        </div>
    </footer>
</body>
</html>