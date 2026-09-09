@extends('layouts.app')

@section('title', 'Beranda — Inspektorat Kota Mojokerto')
@section('meta_description', 'Selamat datang di Zona Integritas Inspektorat Kota Mojokerto. Kenali profil, tugas, dan layanan pengawasan kami.')

@section('content')

{{--
    ====================================================================
    HERO FORMAL (NAVY)
    ====================================================================
--}}
<style>
    :root{
        --ins-navy: var(--navy, #0b2545);
        --ins-navy-dark: #071a33;
        --ins-gold: var(--gold, #d4a94a);
        --ins-slate: var(--slate, #5b6b7d);
        --ins-line: #e4e8ee;
    }

    /* ---------- Topbar tanggal + aksi ---------- */
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
    .ins-topbar-date{
        display: flex;
        align-items: center;
        gap: 8px;
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

    /* ---------- Hero formal ---------- */
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
        gap: 56px;
        align-items: center;
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
        margin-bottom: 18px;
    }
    .ins-breadcrumb::before{
        content: "";
        width: 22px;
        height: 2px;
        background: var(--ins-gold);
        display: inline-block;
    }
    .ins-hero h1{
        font-size: clamp(30px, 4vw, 44px);
        line-height: 1.15;
        color: var(--ins-navy);
        margin: 0 0 18px;
        font-weight: 700;
    }
    .ins-hero h1 em{
        color: var(--ins-gold);
        font-style: normal;
    }
    .ins-hero p.ins-lead{
        color: var(--ins-slate);
        font-size: 16px;
        line-height: 1.7;
        max-width: 520px;
        margin-bottom: 28px;
    }
    .ins-hero-actions{
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }
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
        border: 1.5px solid var(--ins-navy);
    }
    .ins-btn-outline:hover{
        background: var(--ins-navy);
        color: #fff;
    }

    /* ---------- Kartu highlight kanan ---------- */
    .ins-hero-card{
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 20px 45px -18px rgba(11,37,69,.35);
        overflow: hidden;
        border: 1px solid var(--ins-line);
    }
    .ins-hero-card-media{
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
    }
    .ins-hero-card-media img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* ---------- Welcome text ---------- */
    .ins-welcome{
        font-size: 22px;
        font-weight: 600;
        color: var(--ins-navy);
        margin: 0 0 10px;
        letter-spacing: -.01em;
    }
    .ins-welcome strong{
        color: var(--ins-gold);
        font-weight: 700;
    }

    /* ---------- Carousel foto hero ---------- */
    .ins-slides{
        position: relative;
        width: 100%;
        height: 100%;
    }
    .ins-slide{
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .5s ease;
        pointer-events: none;
    }
    .ins-slide.is-active{
        opacity: 1;
        pointer-events: auto;
    }
    .ins-slide img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .ins-slide-nav{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,.9);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 3;
        box-shadow: 0 4px 10px rgba(0,0,0,.15);
        transition: background .2s ease;
    }
    .ins-slide-nav:hover{
        background: #fff;
    }
    .ins-slide-nav svg{
        width: 16px;
        height: 16px;
        stroke: var(--ins-navy);
    }
    .ins-slide-prev{ left: 12px; }
    .ins-slide-next{ right: 12px; }
    .ins-slide-dots{
        position: absolute;
        bottom: 12px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 6px;
        z-index: 3;
    }
    .ins-slide-dot{
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: rgba(255,255,255,.6);
        border: none;
        cursor: pointer;
        padding: 0;
    }
    .ins-slide-dot.is-active{
        background: var(--ins-gold);
        width: 18px;
        border-radius: 4px;
    }

    /* ---------- Layanan Kami (grid, bukan scroll) ---------- */
    .ins-layanan{
        padding: 56px 24px 72px;
        background: #fff;
    }
    .ins-layanan-inner{
        max-width: 1180px;
        margin: 0 auto;
    }
    .ins-layanan-intro{
        max-width: 640px;
        margin-bottom: 36px;
    }
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
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: var(--ins-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        flex-shrink: 0;
    }
    .ins-layanan-icon svg{
        width: 22px;
        height: 22px;
        stroke: #fff;
    }
    .ins-layanan-card h3{
        font-size: 15.5px;
        font-weight: 700;
        color: var(--ins-navy);
        margin: 0 0 8px;
    }
    .ins-layanan-card p{
        font-size: 13px;
        line-height: 1.6;
        color: var(--ins-slate);
        margin: 0 0 16px;
        flex: 1;
    }
    .ins-layanan-link{
        font-size: 12.5px;
        font-weight: 700;
        color: var(--ins-navy);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .ins-layanan-link svg{
        width: 14px;
        height: 14px;
        stroke: currentColor;
    }

    /* ---------- Kartu gabungan: beberapa tautan sekaligus ---------- */
    .ins-layanan-sublinks{
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: auto;
    }
    .ins-layanan-sublink{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        padding: 9px 12px;
        background: #fff;
        border: 1px solid var(--ins-line);
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--ins-navy);
        text-decoration: none;
        transition: all .15s ease;
    }
    .ins-layanan-sublink:hover{
        border-color: var(--ins-navy);
        background: var(--ins-navy);
        color: #fff;
    }
    .ins-layanan-sublink svg{
        width: 13px;
        height: 13px;
        stroke: currentColor;
        flex-shrink: 0;
    }

    @media (max-width: 1024px){
        .ins-layanan-grid{
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 560px){
        .ins-layanan-grid{
            grid-template-columns: 1fr;
        }
    }

    /* ---------- Mengenal Kami (About) ---------- */
    .ins-about{
        padding: 72px 24px;
        background: #f7f8fa;
    }
    .ins-about-inner{
        max-width: 1180px;
        margin: 0 auto;
    }
    .ins-about-intro{
        max-width: 640px;
        margin-bottom: 44px;
    }
    .ins-about-intro h2{
        font-size: clamp(24px, 3vw, 32px);
        color: var(--ins-navy);
        margin: 12px 0 16px;
        font-weight: 700;
    }
    .ins-about-intro p{
        color: var(--ins-slate);
        font-size: 15.5px;
        line-height: 1.75;
        margin-bottom: 24px;
    }
    .ins-about-grid{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }
    .ins-about-card{
        background: #fff;
        border: 1px solid var(--ins-line);
        border-radius: 12px;
        padding: 26px 22px;
        transition: all .2s ease;
    }
    .ins-about-card:hover{
        border-color: var(--ins-navy);
        box-shadow: 0 16px 32px -18px rgba(11,37,69,.25);
        transform: translateY(-3px);
    }
    .ins-about-icon{
        width: 46px;
        height: 46px;
        border-radius: 10px;
        background: var(--ins-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 18px;
    }
    .ins-about-icon svg{
        width: 22px;
        height: 22px;
        stroke: #fff;
    }
    .ins-about-card h3{
        font-size: 16px;
        font-weight: 700;
        color: var(--ins-navy);
        margin: 0 0 10px;
    }
    .ins-about-card p{
        font-size: 13.5px;
        line-height: 1.65;
        color: var(--ins-slate);
        margin: 0;
    }

    @media (max-width: 1024px){
        .ins-about-grid{
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 560px){
        .ins-about-grid{
            grid-template-columns: 1fr;
        }
    }

    /* ---------- Berita Terkini ---------- */
    .ins-berita{
        padding: 72px 24px;
        background: #fff;
    }
    .ins-berita-inner{
        max-width: 1180px;
        margin: 0 auto;
    }
    .ins-berita-head{
        display: flex;
        align-items: center;
        gap: 24px;
        margin-bottom: 32px;
    }
    .ins-berita-head h2{
        font-size: clamp(22px, 3vw, 28px);
        color: var(--ins-navy);
        font-weight: 700;
        white-space: nowrap;
        margin: 0;
    }
    .ins-berita-head .ins-berita-rule{
        flex: 1;
        height: 3px;
        background: var(--ins-navy);
        border-radius: 2px;
    }
    .ins-berita-grid{
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 28px;
        align-items: start;
    }
    .ins-berita-featured{
        display: block;
        text-decoration: none;
        border: 1px solid var(--ins-line);
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .ins-berita-featured:hover{
        box-shadow: 0 20px 40px -20px rgba(11,37,69,.25);
        transform: translateY(-2px);
    }
    .ins-berita-featured-img{
        aspect-ratio: 16/9;
        overflow: hidden;
    }
    .ins-berita-featured-img img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .ins-berita-featured-body{
        padding: 22px 24px 26px;
    }
    .ins-berita-date{
        font-size: 13px;
        color: var(--ins-slate);
        display: block;
        margin-bottom: 8px;
    }
    .ins-berita-featured-body h3{
        font-size: 19px;
        color: var(--ins-navy);
        line-height: 1.4;
        margin: 0 0 12px;
        font-weight: 700;
    }
    .ins-berita-read{
        font-size: 13.5px;
        font-weight: 600;
        color: var(--ins-navy);
    }
    .ins-berita-list{
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .ins-berita-item{
        display: flex;
        gap: 14px;
        text-decoration: none;
        padding: 12px;
        border-radius: 10px;
        transition: background .2s ease;
    }
    .ins-berita-item:hover{
        background: #f7f8fa;
    }
    .ins-berita-item-thumb{
        width: 96px;
        height: 72px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .ins-berita-item-thumb img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .ins-berita-item-body h4{
        font-size: 14.5px;
        color: var(--ins-navy);
        line-height: 1.4;
        margin: 0 0 4px;
        font-weight: 700;
    }
    .ins-berita-more{
        text-align: right;
        margin-top: 4px;
    }
    .ins-berita-more a{
        font-size: 13.5px;
        font-weight: 600;
        color: var(--ins-navy);
        text-decoration: none;
    }
    .ins-berita-more a:hover{
        text-decoration: underline;
    }

    @media (max-width: 900px){
        .ins-berita-grid{
            grid-template-columns: 1fr;
        }
    }

    /* ---------- Galeri Foto ---------- */
    .ins-galeri{
        padding: 20px 24px 72px;
        background: #f7f8fa;
    }
    .ins-galeri-inner{
        max-width: 1180px;
        margin: 0 auto;
    }
    .ins-galeri-grid{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    .ins-galeri-item{
        display: block;
        position: relative;
        aspect-ratio: 4/3;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--ins-line);
        background: #fff;
    }
    .ins-galeri-item img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }
    .ins-galeri-item:hover img{
        transform: scale(1.06);
    }
    .ins-galeri-item::after{
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(7,26,51,.45), transparent 55%);
        opacity: 0;
        transition: opacity .25s ease;
    }
    .ins-galeri-item:hover::after{
        opacity: 1;
    }
    .ins-galeri-more{
        text-align: center;
        margin-top: 32px;
    }

    @media (max-width: 900px){
        .ins-galeri-grid{
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 560px){
        .ins-galeri-grid{
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 900px){
        .ins-hero-inner{
            grid-template-columns: 1fr;
        }
        .ins-topbar-inner{
            font-size: 12px;
        }
    }
</style>

{{-- ============ TOPBAR ============ --}}
<div class="ins-topbar">
    <div class="ins-topbar-inner">
        <span class="ins-topbar-date">
            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, j F Y') }}
        </span>
        <div class="ins-topbar-actions">
            <a href="{{ url('/kontak') }}">Hubungi</a>
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="ins-topbar-login">
                    Login <span>&rarr;</span>
                </a>
            @endif
        </div>
    </div>
</div>

{{-- ============ HERO FORMAL ============ --}}
<section class="ins-hero">
    <div class="ins-hero-inner">
        <div>
            <span class="ins-breadcrumb">Portal Resmi</span>
            <p class="ins-welcome">Selamat Datang di <strong>Inspektorat Kota Mojokerto</strong></p>
            <h1>Menjaga <em>integritas</em>,<br>mengawal tata kelola pemerintahan</h1>
            <p class="ins-lead">
                Kami adalah Aparat Pengawasan Intern Pemerintah (APIP) Kota Mojokerto —
                hadir untuk memastikan setiap program dan anggaran pemerintah kota
                berjalan bersih, akuntabel, dan bebas dari gratifikasi.
            </p>
            <div class="ins-hero-actions">
                <a href="{{ url('/profil') }}" class="ins-btn ins-btn-primary">
                    Lihat Profil Kami
                </a>
                <a href="{{ url('/#layanan') }}" class="ins-btn ins-btn-outline">
                    Jelajahi Layanan
                </a>
            </div>
        </div>

        <div class="ins-hero-card">
            <div class="ins-hero-card-media" id="insHeroCarousel">

                <div class="ins-slides">
                    <div class="ins-slide is-active">
                        <img src="{{ asset('images/hero-banner.png') }}" alt="Suasana rapat konsolidasi pegawai Inspektorat Kota Mojokerto">
                    </div>
                    <div class="ins-slide">
                        <img src="{{ asset('images/team-banner.png') }}" alt="Seluruh pegawai Inspektorat Kota Mojokerto berfoto bersama">
                    </div>
                    {{--
                        Tambah slide lain di sini kalau ada foto baru,
                        cukup copy blok <div class="ins-slide">...</div> di atas
                        dan ganti src gambarnya.
                    --}}
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

    function resetTimer(){
        clearInterval(timer);
        timer = setInterval(next, 5000);
    }

    root.querySelector('.ins-slide-next').addEventListener('click', next);
    root.querySelector('.ins-slide-prev').addEventListener('click', prev);

    resetTimer();
})();
</script>

{{-- ============ LAYANAN UTAMA ============ --}}
<section class="ins-layanan" id="layanan">
    <div class="ins-layanan-inner">
        <div class="ins-layanan-intro">
            <span class="ins-breadcrumb">Layanan Kami</span>
            <h2>Apa yang bisa Anda lakukan di sini?</h2>
            <p>Layanan utama yang bisa langsung Anda akses melalui website ini.</p>
        </div>

        <div class="ins-layanan-grid">
            {{-- Konsultansi Online --}}
            <div class="ins-layanan-card">
                <div class="ins-layanan-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </div>
                <h3>Konsultansi Online</h3>
                <p>Konsultasikan permasalahan pengawasan dan tata kelola Anda langsung dengan tim kami.</p>
                <a href="{{ url('/layanan/konsultansi') }}" class="ins-layanan-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- KMS / Pedoman --}}
            <div class="ins-layanan-card">
                <div class="ins-layanan-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <h3>KMS / Pedoman</h3>
                <p>Kumpulan pedoman dan pengetahuan pengawasan yang bisa diakses dan dipelajari kapan saja.</p>
                <a href="{{ url('/knowledge-base') }}" class="ins-layanan-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- Buletin Pengawasan --}}
            <div class="ins-layanan-card">
                <div class="ins-layanan-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h11a2 2 0 0 1 2 2v14l-4-2-4 2-4-2-4 2V6a2 2 0 0 1 2-2z"/><path d="M9 9h6M9 13h6"/></svg>
                </div>
                <h3>Buletin Pengawasan</h3>
                <p>Publikasi berkala berisi wawasan, kebijakan, dan perkembangan seputar dunia pengawasan.</p>
                <a href="{{ url('/buletin') }}" class="ins-layanan-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- SKM Inspektorat --}}
            <div class="ins-layanan-card">
                <div class="ins-layanan-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                </div>
                <h3>SKM Inspektorat</h3>
                <p>Isi Survei Kepuasan Masyarakat untuk membantu kami terus meningkatkan kualitas layanan.</p>
                <a href="{{ url('/layanan/skm') }}" class="ins-layanan-link">
                    Lihat Layanan
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>

            {{-- Layanan Pengaduan (GABUNGAN: Curhat Ning Ita + GOL KPK + WBS) --}}
            <div class="ins-layanan-card">
                <div class="ins-layanan-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>Layanan Pengaduan</h3>
                <p>Sampaikan aduan, laporan gratifikasi, atau dugaan pelanggaran melalui kanal resmi berikut.</p>
                <div class="ins-layanan-sublinks">
                    <a href="https://curhatningita.lapor.go.id/" target="_blank" rel="noopener noreferrer" class="ins-layanan-sublink">
                        Curhat Ning Ita
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="https://gol.kpk.go.id/" target="_blank" rel="noopener noreferrer" class="ins-layanan-sublink">
                        Gratifikasi Online (KPK)
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                    <a href="https://wbs.mojokertokota.go.id/" target="_blank" rel="noopener noreferrer" class="ins-layanan-sublink">
                        Whistle Blowing System
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
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
                {{-- Berita utama (paling baru) --}}
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

                {{-- Daftar berita lainnya --}}
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
            <p style="color:var(--ins-slate, #5b6b7d);">Belum ada berita yang dipublikasikan. Tambahkan lewat panel Admin.</p>
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
                <a href="{{ route('galeri.index') }}" class="ins-btn ins-btn-primary">
                    Selengkapnya
                </a>
            </div>
        @else
            <p style="color:var(--ins-slate, #5b6b7d); text-align:center;">Belum ada foto galeri yang ditambahkan.</p>
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