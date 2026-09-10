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

    /* ================= HERO (split: teks kiri, foto kanan) ================= */
    .ins-hero{
        background: #f7f8fa;
        padding: 56px 24px 64px;
        border-bottom: 1px solid var(--ins-line);
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

    /* Kartu foto di kanan (carousel) */
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

    /* ================= MENGENAL KAMI ================= */
    .ins-about{ padding: 72px 24px; background: #f7f8fa; }
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

    /* ================= BERITA TERKINI (NAVY BACKGROUND) ================= */
    .ins-berita{ 
        padding: 72px 24px; 
        background: linear-gradient(160deg, var(--ins-navy) 0%, var(--ins-navy-dark) 100%); 
        color: #fff;
    }
    .ins-berita-inner{ max-width: 1180px; margin: 0 auto; }
    .ins-berita-head{ display: flex; align-items: center; gap: 24px; margin-bottom: 32px; }
    .ins-berita-head h2{
        font-size: clamp(22px, 3vw, 28px); color: #fff; font-weight: 700; white-space: nowrap; margin: 0;
    }
    .ins-berita-head .ins-berita-rule{ flex: 1; height: 2px; background: rgba(255,255,255,.2); border-radius: 2px; }
    .ins-berita-grid{ display: grid; grid-template-columns: 1.3fr 1fr; gap: 28px; align-items: start; }
    
    /* Berita Utama */
    .ins-berita-featured{
        display: block; text-decoration: none; border: 1px solid rgba(255,255,255,.12); border-radius: 14px;
        overflow: hidden; background: rgba(255,255,255,.05); backdrop-filter: blur(8px);
        transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease;
    }
    .ins-berita-featured:hover{ 
        box-shadow: 0 20px 40px -20px rgba(0,0,0,.5); 
        transform: translateY(-2px); 
        border-color: var(--ins-gold);
    }
    .ins-berita-featured-img{ aspect-ratio: 16/9; overflow: hidden; }
    .ins-berita-featured-img img{ width: 100%; height: 100%; object-fit: cover; display: block; }
    .ins-berita-featured-body{ padding: 22px 24px 26px; }
    .ins-berita-date{ font-size: 13px; color: rgba(255,255,255,.65); display: block; margin-bottom: 8px; }
    .ins-berita-featured-body h3{ font-size: 19px; color: #fff; line-height: 1.4; margin: 0 0 12px; font-weight: 700; }
    .ins-berita-read{ font-size: 13.5px; font-weight: 600; color: var(--ins-gold); }
    
    /* List Berita Samping */
    .ins-berita-list{ display: flex; flex-direction: column; gap: 14px; }
    .ins-berita-item{ 
        display: flex; gap: 14px; text-decoration: none; padding: 12px; border-radius: 10px; 
        background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08);
        transition: all .2s ease; 
    }
    .ins-berita-item:hover{ 
        background: rgba(255,255,255,.1); 
        border-color: var(--ins-gold);
    }
    .ins-berita-item-thumb{ width: 96px; height: 72px; border-radius: 8px; overflow: hidden; flex-shrink: 0; }
    .ins-berita-item-thumb img{ width: 100%; height: 100%; object-fit: cover; display: block; }
    .ins-berita-item-body h4{ font-size: 14.5px; color: #fff; line-height: 1.4; margin: 0 0 4px; font-weight: 600; }
    .ins-berita-more{ text-align: right; margin-top: 14px; }
    .ins-berita-more a{ font-size: 13.5px; font-weight: 600; color: var(--ins-gold); text-decoration: none; }
    .ins-berita-more a:hover{ text-decoration: underline; }

    @media (max-width: 900px){ .ins-berita-grid{ grid-template-columns: 1fr; } }

    /* ================= GALERI FOTO ================= */
    .ins-galeri{ padding: 72px 24px; background: #f7f8fa; }
    .ins-galeri-inner{ max-width: 1180px; margin: 0 auto; }
    .ins-galeri-head h2{ color: var(--ins-navy); }
    .ins-galeri-head .ins-berita-rule{ background: var(--ins-navy); }
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
                <a href="{{ url('/berita') }}" class="ins-btn ins-btn-outline">Berita Terkini</a>
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
            <div class="ins-about-card">
                <div class="ins-about-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M4 21V8l8-5 8 5v13M9 21v-6h6v6"/></svg>
                </div>
                <h3>Kedudukan</h3>
                <p>{{ $p['kedudukan'] ?? '' }}</p>
            </div>

            <div class="ins-about-card">
                <div class="ins-about-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Peran</h3>
                <p>{{ $p['peran'] ?? '' }}</p>
            </div>

            <div class="ins-about-card">
                <div class="ins-about-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1"/></svg>
                </div>
                <h3>Tujuan</h3>
                <p>{{ $p['tujuan'] ?? '' }}</p>
            </div>

            <div class="ins-about-card">
                <div class="ins-about-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h3>Fungsi</h3>
                <p>{{ $p['fungsi'] ?? $p['fungsi_singkat'] ?? '' }}</p>
            </div>
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
            <p style="color:rgba(255,255,255,.7);">Belum ada berita yang dipublikasikan. Tambahkan lewat panel Admin.</p>
        @endif
    </div>
</section>

{{-- ============ GALERI FOTO ============ --}}
<section class="ins-galeri" id="galeri">
    <div class="ins-galeri-inner">
        <div class="ins-berita-head ins-galeri-head">
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
            <p style="color:var(--ins-slate);">Belum ada galeri foto yang dipublikasikan.</p>
        @endif
    </div>
</section>

@endsection