<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inspektorat Kota Mojokerto')</title>
    <meta name="description" content="@yield('meta_description', 'Website resmi Inspektorat Kota Mojokerto — Zona Integritas menuju wilayah bebas dari korupsi.')">
    <link rel="icon" href="{{ asset('images/logo-mojokerto.png') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app-extra.css') }}">
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
            <nav class="main-nav" id="mainNav" aria-label="Navigasi utama">
                <a href="{{ url('/') }}">Beranda</a>

                <a href="{{ url('/profil') }}">Profil</a>

                <a href="{{ url('/layanan') }}">Layanan</a>
                <a href="{{ url('/berita') }}">Berita</a>
                <a href="{{ url('/kontak') }}" class="nav-cta">Kontak Kami</a>
            </nav>

            <button type="button" class="nav-toggle" id="navToggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mainNav">
                <svg class="nav-toggle-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                <svg class="nav-toggle-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none;"><path d="M6 6l12 12M6 18L18 6"/></svg>
            </button>
        </div>
    </header>

    <main id="konten">
        @yield('content')
    </main>

    <footer>
        <div class="wrap">
            <div class="footer-grid footer-grid-4">
                <div>
                    <div class="footer-brand">
                        <img src="{{ asset('images/logo-mojokerto.png') }}" alt="Logo Pemerintah Kota Mojokerto">
                        <div>
                            <strong>Inspektorat Kota Mojokerto</strong>
                            <p>Aparat Pengawasan Intern Pemerintah yang mengawal tata kelola pemerintahan Kota Mojokerto agar bersih, akuntabel, dan bebas dari korupsi.</p>
                        </div>
                    </div>
                    <div class="footer-map">
                        <iframe
                            src="https://www.google.com/maps?q=Jl.+Benteng+Pancasila+No.+23,+Magersari,+Kota+Mojokerto,+Jawa+Timur+61314&output=embed"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Kantor Inspektorat Kota Mojokerto"></iframe>
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
                        <li>Jl. Benteng Pancasila No. 23, Magersari, Kota Mojokerto, Jawa Timur 61314</li>
                        <li>inspektorat@mojokertokota.go.id</li>
                        <li>(0321) 399630</li>
                    </ul>
                    <div class="footer-social" aria-label="Media sosial">
                        <a href="#" aria-label="Instagram" title="Instagram">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                        </a>
                        <a href="#" aria-label="Facebook" title="Facebook">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 3h-2a5 5 0 0 0-5 5v2H6v4h2v7h4v-7h3l1-4h-4V8a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="#" aria-label="YouTube" title="YouTube">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="5" width="20" height="14" rx="4"/><path d="M10 9l5 3-5 3z" fill="currentColor" stroke="none"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-hours">
                    <strong>Jam Layanan</strong>
                    Senin – Kamis<br>07.30 – 15.30 WIB<br><br>
                    Jumat<br>07.30 – 14.30 WIB<br><br>
                    Sabtu, Minggu & Libur Nasional<br>Tutup
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Inspektorat Kota Mojokerto. Zona Integritas — Tolak Gratifikasi.</span>
                <span>Dibangun dengan Laravel</span>
            </div>
        </div>
    </footer>
    <script>
    (function () {
        var toggle = document.getElementById('navToggle');
        var nav = document.getElementById('mainNav');
        if (!toggle || !nav) return;

        var openIcon = toggle.querySelector('.nav-toggle-open');
        var closeIcon = toggle.querySelector('.nav-toggle-close');

        toggle.addEventListener('click', function () {
            var isOpen = nav.classList.toggle('nav-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            openIcon.style.display = isOpen ? 'none' : 'block';
            closeIcon.style.display = isOpen ? 'block' : 'none';
        });

        // Tutup menu otomatis kalau salah satu link diklik.
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('nav-open');
                toggle.setAttribute('aria-expanded', 'false');
                openIcon.style.display = 'block';
                closeIcon.style.display = 'none';
            });
        });
    })();
    </script>
</body>
</html>