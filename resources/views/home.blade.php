@extends('layouts.app')

@section('title', 'Beranda — Inspektorat Kota Mojokerto')
@section('meta_description', 'Selamat datang di Zona Integritas Inspektorat Kota Mojokerto. Kenali profil, tugas, dan layanan pengawasan kami.')

@section('content')

{{-- ============ HERO ============ --}}
<section class="hero">
    <div class="hero-media">
        <img src="{{ asset('images/hero-banner.png') }}" alt="Suasana rapat konsolidasi pegawai Inspektorat Kota Mojokerto">
    </div>

    <div class="integrity-seal" aria-hidden="true">
        <svg viewBox="0 0 100 100">
            <path id="sealCircle" fill="none" d="M 50,50 m -38,0 a 38,38 0 1,1 76,0 a 38,38 0 1,1 -76,0"/>
            <text font-family="IBM Plex Mono, monospace" font-size="7.6" letter-spacing="2" fill="#fff">
                <textPath href="#sealCircle">• ZONA INTEGRITAS • TOLAK GRATIFIKASI • ZONA INTEGRITAS •</textPath>
            </text>
        </svg>
        <span class="seal-core">Bebas<br>Korupsi</span>
    </div>

    <div class="hero-inner">
        <div class="wrap">
            <span class="eyebrow">Inspektorat Kota Mojokerto</span>
            <h1>Menjaga <em>integritas</em>,<br>mengawal tata kelola pemerintahan</h1>
            <p class="lead">
                Kami adalah Aparat Pengawasan Intern Pemerintah (APIP) Kota Mojokerto —
                hadir untuk memastikan setiap program dan anggaran pemerintah kota
                berjalan bersih, akuntabel, dan bebas dari gratifikasi.
            </p>
            <div class="hero-actions">
                <a href="{{ url('/profil') }}" class="btn btn-gold">
                    Lihat Profil Kami
                </a>
                <a href="{{ url('/layanan') }}" class="btn btn-ghost">
                    Jelajahi Layanan
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============ APA ITU INSPEKTORAT ============ --}}
<section class="about" id="apa-itu">
    <div class="wrap about-grid">
        <div class="about-copy">
            <span class="eyebrow" style="color:var(--gold);">Mengenal Kami</span>
            <h2 style="font-size:clamp(24px,3vw,32px);margin:14px 0 18px;">Inspektorat itu apa, sebenarnya?</h2>
            <p>{{ $p['tentang_intro'] ?? '' }}</p>
            <a href="{{ url('/profil') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;">
                Selengkapnya tentang Profil
            </a>
        </div>

        <div class="definition-list">
            <div class="def-card">
                <span class="seal-mark">K</span>
                <h3>Kedudukan</h3>
                <p>{{ $p['kedudukan'] ?? '' }}</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">P</span>
                <h3>Peran</h3>
                <p>{{ $p['peran'] ?? '' }}</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">T</span>
                <h3>Tujuan</h3>
                <p>{{ $p['tujuan'] ?? '' }}</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">F</span>
                <h3>Fungsi</h3>
                <p>{{ $p['fungsi_singkat'] ?? '' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ LAYANAN UTAMA ============ --}}
<section class="services" id="layanan">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Layanan Kami</span>
            <h2>Apa yang bisa Anda lakukan di sini?</h2>
            <p>Empat layanan utama yang bisa langsung Anda akses melalui website ini.</p>
        </div>

        <div class="service-grid">
            {{-- Konsultansi Online --}}
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </div>
                <h3>Konsultansi Online</h3>
                <p>Konsultasikan permasalahan pengawasan dan tata kelola Anda langsung dengan tim kami.</p>
                <a href="{{ url('/layanan/konsultansi') }}" class="service-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- KMS / Pedoman --}}
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <h3>KMS / Pedoman</h3>
                <p>Kumpulan pedoman dan pengetahuan pengawasan yang bisa diakses dan dipelajari kapan saja.</p>
                <a href="{{ url('/layanan/kms') }}" class="service-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- Buletin Pengawasan --}}
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h11a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V6a2 2 0 0 1 2-2z"/><path d="M9 9h6M9 13h6"/></svg>
                </div>
                <h3>Buletin Pengawasan</h3>
                <p>Publikasi berkala berisi wawasan, kebijakan, dan perkembangan seputar dunia pengawasan.</p>
                <a href="{{ url('/layanan/buletin') }}" class="service-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- SKM Inspektorat --}}
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h3>SKM Inspektorat</h3>
                <p>Isi Survei Kepuasan Masyarakat untuk membantu kami terus meningkatkan kualitas layanan.</p>
                <a href="{{ url('/layanan/skm') }}" class="service-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============ D. ARTIKEL / INFORMASI TERBARU ============ --}}
<section class="articles" id="artikel">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Informasi Terbaru</span>
            <h2>Artikel & Kabar dari Inspektorat</h2>
            <p>Update kegiatan, pengumuman, dan berita seputar pengawasan — dikelola langsung oleh admin.</p>
        </div>

        @if ($articles->isNotEmpty())
            <div class="article-grid">
                @foreach ($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="article-card">
                        <div class="article-thumb">
                            <img src="{{ $article->cover_url }}" alt="{{ $article->title }}">
                        </div>
                        <div class="article-body">
                            <span class="eyebrow" style="margin-bottom:0;">{{ $article->category ?? 'Artikel' }}</span>
                            <h3>{{ $article->title }}</h3>
                            <span class="article-date">{{ $article->tanggal_indo }}</span>
                            <span class="article-read">
                                Baca
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p style="color:var(--slate);">Belum ada artikel yang dipublikasikan. Tambahkan lewat panel Admin.</p>
        @endif
    </div>
</section>

{{-- ============ E. STATISTIK SINGKAT (opsional) ============ --}}
<section class="stats" id="statistik">
    <div class="wrap">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number">{{ $stats['artikel'] }}</div>
                <div class="stat-label">Jumlah Artikel</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['pedoman'] }}</div>
                <div class="stat-label">Jumlah Pedoman</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['layanan'] }}</div>
                <div class="stat-label">Jumlah Layanan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['publikasi'] }}</div>
                <div class="stat-label">Jumlah Publikasi</div>
            </div>
        </div>
    </div>
</section>

{{-- ============ TEAM STRIP ============ --}}
<section class="team-strip">
    <img src="{{ asset('images/team-banner.png') }}" alt="Seluruh pegawai Inspektorat Kota Mojokerto berfoto bersama di halaman kantor">
    <div class="team-caption">
        <div class="wrap">
            <p>Bersama, menuju wilayah bebas dari korupsi</p>
        </div>
    </div>
</section>

@endsection