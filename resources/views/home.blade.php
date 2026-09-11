@extends('layouts.app')

@section('title', 'Beranda — Inspektorat Kota Mojokerto')
@section('meta_description', 'Selamat datang di Zona Integritas Inspektorat Kota Mojokerto. Kenali profil, tugas, dan layanan pengawasan kami.')

@section('content')

<style>
    :root{
        --ins-navy: var(--navy, #0b2545);
        --ins-navy-dark: #071a33;
        --ins-gold: var(--gold, #d4a94a);
        --ins-slate: var(--slate, #5b6b7d);
        --ins-line: #e4e8ee;
    }

    /* ================= TOPBAR ================= */
    .ins-topbar{
        background: var(--ins-navy-dark);
        color: #cfd9e6;
        font-size: 13px;
    }
    .ins-topbar-inner{
        max-width: 1180px;
        margin: 0 auto;
        padding: 8px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }
    .ins-topbar-actions{
        display: flex;
        align-items: center;
        gap: 20px;
    }
    .ins-topbar-actions a{
        color: #cfd9e6;
        text-decoration: none;
    }
    .ins-topbar-actions a:hover{
        color: #fff;
    }
    .ins-topbar-login{
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--ins-gold) !important;
        font-weight: 600;
    }

    /* ================= TOMBOL & LABEL UMUM ================= */
    .ins-btn{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 26px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all .2s ease;
        border: 1.5px solid transparent;
    }
    .ins-btn-primary{
        background: var(--ins-navy);
        color: #fff;
    }
    .ins-btn-primary:hover{
        background: var(--ins-navy-dark);
        color: #fff;
    }
    .ins-btn-outline{
        background: transparent;
        color: var(--ins-navy);
        border-color: var(--ins-navy);
    }
    .ins-btn-outline:hover{
        background: var(--ins-navy);
        color: #fff;
    }
    .ins-breadcrumb{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--ins-navy);
        margin-bottom: 16px;
    }
    .ins-breadcrumb::before{
        content: "";
        width: 22px;
        height: 2px;
        background: var(--ins-gold);
        display: inline-block;
    }
    .ins-breadcrumb-light{ color: var(--ins-gold); }

    /* ================= HERO (split: teks kiri, foto kanan) ================= */
    .ins-hero{
        background: linear-gradient(135deg, #eef2f7 0%, #d9e2ef 100%);
        padding: 56px 24px 64px;
        border-bottom: 1px solid var(--ins-line);
        position: relative;
    }
    .ins-hero-inner{
        max-width: 1180px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.05fr 0.95fr;
        gap: 52px;
        align-items: center;
    }
    .ins-welcome{
        font-size: 28px;
        font-weight: 700;
        color: var(--ins-navy);
        margin: 0 0 12px;
        letter-spacing: -.01em;
    }
    .ins-welcome strong{
        color: var(--ins-gold);
        font-weight: 700;
    }
    .ins-hero h1{
        font-size: clamp(28px, 3.6vw, 40px);
        line-height: 1.18;
        color: var(--ins-navy);
        margin: 0 0 16px;
        font-weight: 700;
    }
    .ins-hero h1 em{
        color: var(--ins-gold);
        font-style: normal;
    }
    .ins-lead{
        color: var(--ins-slate);
        font-size: 15.5px;
        line-height: 1.75;
        max-width: 520px;
        margin-bottom: 28px;
    }
    .ins-hero-actions{
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    /* Kartu foto di kanan (carousel, TANPA teks di atasnya) */
    .ins-hero-card{
        position: relative;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 24px 50px -20px rgba(11,37,69,.35);
        border: 1px solid var(--ins-line);
    }
    .ins-hero-card::before{
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--ins-gold), var(--ins-navy));
        z-index: 5;
    }
    .ins-hero-card-media{
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .ins-slides{ position: absolute; inset: 0; }
    .ins-slide{
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .7s ease;
    }
    .ins-slide.is-active{ opacity: 1; }
    .ins-slide img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center 75%;
        display: block;
    }
    .ins-slide-nav{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255,255,255,.92);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,.18);
        z-index: 4;
        transition: background .2s ease;
    }
    .ins-slide-nav:hover{ background: #fff; }
    .ins-slide-nav svg{ width: 17px; height: 17px; stroke: var(--ins-navy); }
    .ins-slide-prev{ left: 14px; }
    .ins-slide-next{ right: 14px; }
    .ins-slide-dots{
        position: absolute;
        bottom: 14px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
        z-index: 4;
    }
    .ins-slide-dot{
        width: 7px; height: 7px;
        border-radius: 50%;
        background: rgba(255,255,255,.6);
        border: none;
        cursor: pointer;
        padding: 0;
        transition: all .2s ease;
    }
    .ins-slide-dot.is-active{
        background: var(--ins-gold);
        width: 20px;
        border-radius: 4px;
    }

    @media (max-width: 900px){
        .ins-hero-inner{ grid-template-columns: 1fr; }
        .ins-topbar-inner{ font-size: 12px; }
    }

    /* ================= LAYANAN KAMI (grid) ================= */
    .ins-layanan{
        padding: 72px 24px;
        background: #fff;
    }
    .ins-layanan-inner{ max-width: 1180px; margin: 0 auto; }
    .ins-layanan-intro{ max-width: 640px; margin-bottom: 36px; }
    .ins-layanan-intro h2{
        font-size: clamp(24px, 3vw, 32px);
        color: var(--ins-navy);
        margin: 12px 0 10px;
        font-weight: 700;
    }
    .ins-layanan-intro p{
        color: var(--ins-slate);
        font-size: 15px;
        line-height: 1.7;
        margin: 0;
    }
    .ins-layanan-grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .ins-layanan-card{
        background: #f7f8fa;
        border: 1px solid var(--ins-line);
        border-radius: 12px;
        padding: 26px 22px;
        display: flex;
        flex-direction: column;
        transition: all .2s ease;
    }
    .ins-layanan-card:hover{
        background: #fff;
        border-color: var(--ins-navy);
        box-shadow: 0 16px 32px -18px rgba(11,37,69,.25);
        transform: translateY(-3px);
    }
    .ins-layanan-icon{
        width: 46px; height: 46px;
        border-radius: 10px;
        background: var(--ins-navy);
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
        flex-shrink: 0;
    }
    .ins-layanan-icon svg{ width: 22px; height: 22px; stroke: #fff; }
    .ins-layanan-card h3{
        font-size: 15.5px; font-weight: 700; color: var(--ins-navy); margin: 0 0 8px;
    }
    .ins-layanan-card p{
        font-size: 13px; line-height: 1.6; color: var(--ins-slate); margin: 0 0 16px; flex: 1;
    }
    .ins-layanan-link{
        font-size: 12.5px; font-weight: 700; color: var(--ins-navy);
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        text-transform: uppercase; letter-spacing: .04em;
    }
    .ins-layanan-link svg{ width: 14px; height: 14px; stroke: currentColor; }
    .ins-layanan-sublinks{ display: flex; flex-direction: column; gap: 8px; margin-top: auto; }
    .ins-layanan-sublink{
        display: flex; align-items: center; justify-content: space-between; gap: 8px;
        padding: 9px 12px; background: #fff; border: 1px solid var(--ins-line); border-radius: 8px;
        font-size: 12px; font-weight: 600; color: var(--ins-navy); text-decoration: none;
        transition: all .15s ease;
    }
    .ins-layanan-sublink:hover{ border-color: var(--ins-navy); background: var(--ins-navy); color: #fff; }
    .ins-layanan-sublink svg{ width: 13px; height: 13px; stroke: currentColor; flex-shrink: 0; }

    @media (max-width: 1024px){ .ins-layanan-grid{ grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px){ .ins-layanan-grid{ grid-template-columns: 1fr; } }

    /* ================= MENGENAL KAMI ================= */
    .ins-about{ padding: 72px 24px; background: linear-gradient(135deg, #eef2f7 0%, #d9e2ef 100%); }
    .ins-about-inner{ max-width: 1180px; margin: 0 auto; }
    .ins-about-intro{ max-width: 640px; margin-bottom: 44px; }
    .ins-about-intro h2{
        font-size: clamp(24px, 3vw, 32px); color: var(--ins-navy); margin: 12px 0 16px; font-weight: 700;
    }
    .ins-about-intro p{ color: var(--ins-slate); font-size: 15.5px; line-height: 1.75; margin-bottom: 0; }
    .ins-about-grid{ display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .ins-about-card{
        background: #fff; border: 1px solid var(--ins-line); border-radius: 12px; padding: 26px 22px;
        transition: all .2s ease;
    }
    .ins-about-card:hover{
        border-color: var(--ins-navy); box-shadow: 0 16px 32px -18px rgba(11,37,69,.25); transform: translateY(-3px);
    }
    .ins-about-icon{
        width: 46px; height: 46px; border-radius: 10px; background: var(--ins-navy);
        display: flex; align-items: center; justify-content: center; margin-bottom: 18px;
    }
    .ins-about-icon svg{ width: 22px; height: 22px; stroke: #fff; }
    .ins-about-card h3{ font-size: 16px; font-weight: 700; color: var(--ins-navy); margin: 0 0 10px; }
    .ins-about-card p{ font-size: 13.5px; line-height: 1.65; color: var(--ins-slate); margin: 0; }

    @media (max-width: 1024px){ .ins-about-grid{ grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px){ .ins-about-grid{ grid-template-columns: 1fr; } }

    /* ================= STATISTIK RINGKAS ================= */
    .ins-stats-band{
        background: linear-gradient(160deg, var(--ins-navy) 0%, var(--ins-navy-dark) 100%);
        padding: 60px 24px;
        position: relative;
        overflow: hidden;
    }
    .ins-stats-band::before{
        content: ""; position: absolute; top: -80px; right: -80px; width: 320px; height: 320px;
        border-radius: 50%; background: radial-gradient(circle, rgba(212,169,74,.12) 0%, transparent 70%);
        pointer-events: none;
    }
    .ins-stats-inner{
        max-width: 1180px; margin: 0 auto; display: flex; align-items: center; gap: 48px;
        flex-wrap: wrap; position: relative; z-index: 1;
    }
    .ins-stats-intro{ flex: 0 0 auto; min-width: 220px; }
    .ins-stats-intro h2{
        font-size: clamp(20px, 2.4vw, 26px); color: #fff; font-weight: 700; margin: 10px 0 0; line-height: 1.3;
    }
    .ins-stats-grid{ flex: 1; display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; min-width: 0; }
    .ins-stat-item{ border-left: 2px solid rgba(212,169,74,.4); padding-left: 18px; }
    .ins-stat-number{ font-size: clamp(28px, 3vw, 38px); font-weight: 700; color: #fff; line-height: 1.1; }
    .ins-stat-label{ font-size: 13px; color: rgba(255,255,255,.65); margin-top: 6px; }

    @media (max-width: 900px){
        .ins-stats-inner{ flex-direction: column; align-items: flex-start; }
        .ins-stats-grid{ grid-template-columns: repeat(2, 1fr); width: 100%; }
    }
    @media (max-width: 480px){ .ins-stats-grid{ grid-template-columns: 1fr; } }

    /* ================= BERITA TERKINI ================= */
    .ins-berita{
        padding: 72px 24px;
        background: linear-gradient(160deg, var(--ins-navy) 0%, var(--ins-navy-dark) 100%);
    }
    .ins-berita-inner{ max-width: 1180px; margin: 0 auto; }
    .ins-berita-head{ display: flex; align-items: center; gap: 24px; margin-bottom: 32px; }
    .ins-berita-head h2{
        font-size: clamp(22px, 3vw, 28px); color: #fff; font-weight: 700; white-space: nowrap; margin: 0;
    }
    .ins-berita-head .ins-berita-rule{ flex: 1; height: 3px; background: var(--ins-gold); border-radius: 2px; }
    .ins-berita-grid{ display: grid; grid-template-columns: 1.3fr 1fr; gap: 28px; align-items: start; }
    .ins-berita-featured{
        display: block; text-decoration: none; border: 1.5px solid var(--ins-gold); border-radius: 14px;
        overflow: hidden; background: #fff; transition: box-shadow .2s ease, transform .2s ease;
    }
    .ins-berita-featured:hover{ box-shadow: 0 20px 40px -20px rgba(11,37,69,.25); transform: translateY(-2px); }
    .ins-berita-featured-img{ aspect-ratio: 16/9; overflow: hidden; }
    .ins-berita-featured-img img{ width: 100%; height: 100%; object-fit: cover; display: block; }
    .ins-berita-featured-body{ padding: 22px 24px 26px; }
    .ins-berita-date{ font-size: 13px; color: var(--ins-slate); display: block; margin-bottom: 8px; }
    .ins-berita-featured-body h3{ font-size: 19px; color: var(--ins-navy); line-height: 1.4; margin: 0 0 12px; font-weight: 700; }
    .ins-berita-read{ font-size: 13.5px; font-weight: 600; color: var(--ins-navy); }
    .ins-berita-list{ display: flex; flex-direction: column; gap: 14px; }
    .ins-berita-item{ display: flex; gap: 14px; text-decoration: none; padding: 12px; border-radius: 10px; border: 1.5px solid var(--ins-gold); transition: background .2s ease; }
    .ins-berita-list .ins-berita-item + .ins-berita-item{ margin-top: 0; }
    .ins-berita-item:hover{ background: rgba(255,255,255,.08); }
    .ins-berita-item-thumb{ width: 96px; height: 72px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .ins-berita-item-thumb img{ width: 100%; height: 100%; object-fit: cover; display: block; }
    .ins-berita-item .ins-berita-date{ color: rgba(255,255,255,.65); }
    .ins-berita-item-body h4{ font-size: 14.5px; color: #fff; line-height: 1.4; margin: 0 0 4px; font-weight: 700; }
    .ins-berita-item .ins-berita-read{ color: var(--ins-gold); }
    .ins-berita-more{ text-align: right; margin-top: 4px; }
    .ins-berita-more a{ font-size: 13.5px; font-weight: 600; color: #fff; text-decoration: none; }
    .ins-berita-more a:hover{ text-decoration: underline; }

    @media (max-width: 900px){ .ins-berita-grid{ grid-template-columns: 1fr; } }

    /* ================= GALERI FOTO ================= */
    .ins-galeri{ padding: 20px 24px 72px; background: #f7f8fa; }
    .ins-galeri-inner{ max-width: 1180px; margin: 0 auto; }
    .ins-galeri-grid{ display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
    .ins-galeri-item{
        display: block; position: relative; aspect-ratio: 4/3; border-radius: 12px; overflow: hidden;
        border: 1px solid var(--ins-line); background: #fff;
    }
    .ins-galeri-item img{ width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .35s ease; }
    .ins-galeri-item:hover img{ transform: scale(1.06); }
    .ins-galeri-item::after{
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(7,26,51,.45), transparent 55%);
        opacity: 0; transition: opacity .25s ease;
    }
    .ins-galeri-item:hover::after{ opacity: 1; }
    .ins-galeri-more{ text-align: center; margin-top: 32px; }

    @media (max-width: 900px){ .ins-galeri-grid{ grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px){ .ins-galeri-grid{ grid-template-columns: 1fr; } }
</style>


{{-- ============ HERO (teks kiri, foto kanan) ============ --}}
<section class="ins-hero">
    <div class="ins-hero-inner">
        <div>
            <span class="ins-breadcrumb">Portal Resmi</span>
            <p class="ins-welcome">Selamat Datang di <strong>Inspektorat Kota Mojokerto</strong></p>
            <h1>Menjaga <em>Integritas</em>, Mengawal Tata Kelola Pemerintahan</h1>
            <p class="ins-lead">
                Inspektorat Kota Mojokerto merupakan Aparat Pengawasan Intern Pemerintah (APIP)
                yang berperan mengawasi penyelenggaraan pemerintahan daerah, guna memastikan
                setiap program dan anggaran dikelola secara bersih, akuntabel, dan bebas dari
                praktik gratifikasi.
            </p>
            <div class="ins-hero-actions">
                <a href="{{ url('/profil') }}" class="ins-btn ins-btn-primary">Lihat Profil Kami</a>
                <a href="{{ url('/#layanan') }}" class="ins-btn ins-btn-outline">Jelajahi Layanan</a>
            </div>
        </div>

        <div class="ins-hero-card" id="insHeroCarousel">
            <div class="ins-hero-card-media">
                <div class="ins-slides">
                    <div class="ins-slide is-active">
                        <img src="{{ asset('images/hero-banner.png') }}" alt="Suasana rapat konsolidasi pegawai Inspektorat Kota Mojokerto">
                    </div>
                    <div class="ins-slide">
                        <img src="{{ asset('images/team-banner.png') }}" alt="Seluruh pegawai Inspektorat Kota Mojokerto berfoto bersama">
                    </div>
                    {{-- Tambah slide lain: copy blok <div class="ins-slide">...</div> di atas --}}
                </div>
                <button type="button" class="ins-slide-nav ins-slide-prev" aria-label="Sebelumnya">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button type="button" class="ins-slide-nav ins-slide-next" aria-label="Berikutnya">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                <div class="ins-slide-dots"></div>
            </div>
        </div>
    </div>
</section>

<script>
(function(){
    const root = document.getElementById('insHeroCarousel');
    if(!root) return;
    const slides = root.querySelectorAll('.ins-slide');
    const dotsWrap = root.querySelector('.ins-slide-dots');
    let current = 0;
    let timer = null;

    slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'ins-slide-dot' + (i === 0 ? ' is-active' : '');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(dot);
    });
    const dots = root.querySelectorAll('.ins-slide-dot');

    function goTo(index){
        slides[current].classList.remove('is-active');
        dots[current].classList.remove('is-active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('is-active');
        dots[current].classList.add('is-active');
        resetTimer();
    }
    function next(){ goTo(current + 1); }
    function prev(){ goTo(current - 1); }
    function resetTimer(){ clearInterval(timer); timer = setInterval(next, 5000); }

    root.querySelector('.ins-slide-next').addEventListener('click', next);
    root.querySelector('.ins-slide-prev').addEventListener('click', prev);
    resetTimer();
})();
</script>

{{-- ============ MENGENAL KAMI ============ --}}
<section class="ins-about" id="apa-itu">
    <div class="ins-about-inner">
        <div class="ins-about-intro">
            <span class="ins-breadcrumb">Mengenal Kami</span>
            <h2>Inspektorat itu apa, sebenarnya?</h2>
            <p>
                {{ $p['tentang_intro'] ?? 'Inspektorat Kota Mojokerto adalah Aparat Pengawasan Intern Pemerintah (APIP) yang bertugas mengawasi jalannya penyelenggaraan pemerintahan daerah, memastikan setiap program dan anggaran dikelola secara bersih, akuntabel, dan sesuai aturan yang berlaku.' }}
            </p>
        </div>

        <div class="ins-about-grid">
            @forelse ($highlights as $item)
                <div class="ins-about-card">
                    <div class="ins-about-icon">
                        <span style="color:#fff;font-weight:700;font-size:18px;">{{ \Illuminate\Support\Str::substr($item->judul, 0, 1) }}</span>
                    </div>
                    <h3>{{ $item->judul }}</h3>
                    <p>{{ $item->deskripsi }}</p>
                </div>
            @empty
                <p style="color:var(--ins-slate);grid-column:1/-1;">
                    Belum ada kartu profil. Tambahkan lewat halaman Admin &rarr; Tentang Inspektorat & Visi Misi.
                </p>
            @endforelse
        </div>
    </div>
</section>


{{-- ============ BERITA TERKINI ============ --}}
<section class="ins-berita" id="artikel">
    <div class="ins-berita-inner">
        <div class="ins-berita-head">
            <h2>Berita Terkini</h2>
            <div class="ins-berita-rule"></div>
        </div>

        @if ($articles->isNotEmpty())
            <div class="ins-berita-grid">
                @php $featured = $articles->first(); @endphp
                <a href="{{ route('articles.show', $featured->slug) }}" class="ins-berita-featured">
                    <div class="ins-berita-featured-img">
                        <img src="{{ $featured->cover_url }}" alt="{{ $featured->title }}">
                    </div>
                    <div class="ins-berita-featured-body">
                        <span class="ins-berita-date">{{ $featured->tanggal_indo }}</span>
                        <h3>{{ $featured->title }}</h3>
                        <span class="ins-berita-read">Baca Selengkapnya...</span>
                    </div>
                </a>

                <div>
                    <div class="ins-berita-list">
                        @foreach ($articles->skip(1) as $article)
                            <a href="{{ route('articles.show', $article->slug) }}" class="ins-berita-item">
                                <div class="ins-berita-item-thumb">
                                    <img src="{{ $article->cover_url }}" alt="{{ $article->title }}">
                                </div>
                                <div class="ins-berita-item-body">
                                    <span class="ins-berita-date">{{ $article->tanggal_indo }}</span>
                                    <h4>{{ $article->title }}</h4>
                                    <span class="ins-berita-read">Baca Selengkapnya...</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="ins-berita-more">
                        <a href="{{ route('berita.index') }}">Berita lainnya...</a>
                    </div>
                </div>
            </div>
        @else
            <p style="color:var(--ins-slate);">Belum ada berita yang dipublikasikan. Tambahkan lewat panel Admin.</p>
        @endif
    </div>
</section>

{{-- ============ GALERI FOTO ============ --}}
<section class="ins-galeri" id="galeri">
    <div class="ins-galeri-inner">
        <div class="ins-berita-head">
            <h2>Galeri Foto</h2>
            <div class="ins-berita-rule"></div>
        </div>

        @if ($galeries->isNotEmpty())
            <div class="ins-galeri-grid">
                @foreach ($galeries as $item)
                    <a href="{{ route('galeri.show', $item->slug) }}" class="ins-galeri-item">
                        <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}">
                    </a>
                @endforeach
            </div>
            <div class="ins-galeri-more">
                <a href="{{ route('galeri.index') }}" class="ins-btn ins-btn-primary">Selengkapnya</a>
            </div>
        @else
            <p style="color:var(--ins-slate); text-align:center;">Belum ada foto galeri yang ditambahkan.</p>
        @endif
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