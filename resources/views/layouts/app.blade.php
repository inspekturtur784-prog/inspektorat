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

<!-- TOPBAR LENGKAP SOSMED & SEARCH (LEBIH BESAR) -->
<div style="background-color: #071a33 !important; color: #cfd9e6 !important; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.1); width: 100%;">
    <div class="wrap" style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; padding-bottom: 10px;">
        
        <!-- Tanggal -->
        <span style="color: #cfd9e6 !important; font-weight: 500;">
            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, j F Y') }}
        </span>

        <!-- Sisi Kanan: Sosmed IG + Search Form + Login -->
        <div style="display: flex; align-items: center; gap: 18px;">
            
            <!-- Ikon Instagram -->
            <a href="https://www.instagram.com/inspektoratkotamr?igsi=MzZoa2puaXZ4aGN2" target="_blank" title="Instagram Inspektorat" style="color: #fff; text-decoration: none; display: flex; align-items: center; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
            </a>
            <!-- Ikon Login/Dashboard Admin (otomatis cek status login) -->
            <a href="{{ auth()->check() ? url('/admin') : url('/admin/login') }}"
               title="{{ auth()->check() ? 'Dashboard Admin' : 'Login Admin' }}"
               style="position: relative; z-index: 9999; display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background-color: rgba(212, 169, 74, 0.2); transition: all 0.2s; text-decoration: none; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#d4a94a" style="width: 22px; height: 22px; pointer-events: none;">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-3.8-.85-5.05-2.2.12-1.68 3.37-2.8 5.05-2.8s4.93 1.12 5.05 2.8C15.8 19.15 14.03 20 12 20z"/>
                </svg>
            </a>
        </div>

    </div>
</div>
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

    <!-- Dropdown Layanan (SKM Sudah Dihapus dari Sini) -->
    <div class="nav-item">
        <a href="#">
            Layanan 
            <svg class="nav-caret" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
        </a>
        <div class="nav-dropdown">
            <a href="{{ url('/layanan/konsultansi') }}">
                <strong>Konsultansi Online</strong>
                <span>Layanan konsultasi pengawasan</span>
            </a>
            <a href="{{ url('/knowledge-base') }}">
                <strong>KMS / Pedoman</strong>
                <span>Sistem Manajemen Pengetahuan</span>
            </a>
            <a href="{{ url('/buletin') }}">
                <strong>Buletin Pengawasan</strong>
                <span>Publikasi & wawasan berkala</span>
            </a>

            <div class="dropdown-divider" style="height: 1.5px; background: #e2e8f0; margin: 18px 0 10px 0;"></div>
            <div style="padding: 6px 14px; font-size: 13px; font-weight: 800; text-transform: uppercase; color: #c59b27; letter-spacing: 0.08em; background: rgba(197, 155, 39, 0.08); border-radius: 4px; margin: 0 8px 6px 8px;">
                Layanan Pengaduan
            </div>

            <a href="https://curhatningita.lapor.go.id/" target="_blank" rel="noopener">
                <strong>Curhat Ning Ita</strong>
                <span>Aplikasi pengaduan masyarakat</span>
            </a>
            <a href="https://gol.kpk.go.id/" target="_blank" rel="noopener">
                <strong>Gratifikasi Online (KPK)</strong>
                <span>Pelaporan gratifikasi</span>
            </a>
            <a href="https://wbs.mojokertokota.go.id/" target="_blank" rel="noopener">
                <strong>Whistle Blowing System</strong>
                <span>Pelaporan pelanggaran internal</span>
            </a>
        </div>
    </div>

    <a href="{{ url('/berita') }}">Berita</a>
    <a href="{{ url('/layanan/skm') }}">SKM</a> 
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
    <a href="https://www.instagram.com/inspektoratkotamr" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
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