<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inspektorat — Portal Pengawasan Internal Pemerintah</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,900&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --navy:#0B2A4A;
    --navy-deep:#06182E;
    --navy-soft:#12335A;
    --navy-soft-2:#0D2440;
    --ink:#F3EFE4;
    --ink-70:rgba(243,239,228,.72);
    --ink-40:rgba(243,239,228,.42);
    --parchment:var(--navy-deep);
    --parchment-2:var(--navy-soft-2);
    --paper:var(--navy-soft);
    --verified:#4CAE81;
    --verified-dim:#1B3B2E;
    --brass:#D6A93A;
    --brass-dim:#E4C77C;
    --rust:#C24E38;
    --line: rgba(243,239,228,.14);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html{scroll-behavior:smooth;}
  body{
    background:var(--parchment);
    color:var(--ink);
    font-family:'IBM Plex Sans', sans-serif;
    line-height:1.5;
    -webkit-font-smoothing:antialiased;
  }
  @media (prefers-reduced-motion: reduce){
    *{animation:none !important; transition:none !important;}
  }
  img,svg{display:block; max-width:100%;}
  a{color:inherit; text-decoration:none;}
  .wrap{max-width:1160px; margin:0 auto; padding:0 28px;}
  h1,h2,h3,.display{font-family:'Fraunces', serif; letter-spacing:-.01em;}
  .mono{font-family:'IBM Plex Mono', monospace;}
  .eyebrow{
    font-family:'IBM Plex Mono', monospace;
    font-size:12.5px; letter-spacing:.14em; text-transform:uppercase;
    color:var(--verified); font-weight:500;
    display:flex; align-items:center; gap:10px;
  }
  .eyebrow::before{content:""; width:16px; height:1px; background:var(--verified);}

  /* ===== HEADER ===== */
  header{
    position:sticky; top:0; z-index:50;
    background:rgba(6,24,46,.9);
    backdrop-filter:blur(8px);
    border-bottom:1px solid var(--line);
  }
  .nav-row{
    display:flex; align-items:center; justify-content:space-between;
    height:76px;
  }
  .brand{display:flex; align-items:center; gap:12px;}
  .brand-mark{
  height:40px;
  display:flex; align-items:center; justify-content:center;
}
.brand-mark img{
  height:100%; width:auto; object-fit:contain;
}
  .brand-mark img{
    width:100%; height:100%; object-fit:contain; padding:4px;
  }
  .brand-text{display:flex; flex-direction:column; line-height:1.15;}
  .brand-text b{font-family:'Fraunces', serif; font-size:17px; font-weight:700; letter-spacing:.02em;}
  .brand-text span{font-family:'IBM Plex Mono', monospace; font-size:10.5px; letter-spacing:.08em; color:var(--ink-70); text-transform:uppercase;}

  nav.main-nav{display:flex; align-items:center; gap:36px;}
  nav.main-nav a{
    font-size:14.5px; font-weight:500; color:var(--ink-70);
    position:relative; padding:4px 0;
  }
  nav.main-nav a:hover{color:var(--ink);}
  nav.main-nav a::after{
    content:""; position:absolute; left:0; bottom:-2px; width:0; height:1.5px;
    background:var(--rust); transition:width .25s ease;
  }
  nav.main-nav a:hover::after{width:100%;}

  .cta-btn{
    background:var(--rust); color:var(--ink); font-size:13.5px; font-weight:600;
    padding:10px 20px; border-radius:3px; letter-spacing:.02em;
    border:1px solid var(--rust);
    transition:background .2s ease;
  }
  .cta-btn:hover{background:#a83f2c;}
  .cta-ghost{
    border:1px solid var(--ink); color:var(--ink); font-size:13.5px; font-weight:600;
    padding:10px 20px; border-radius:3px;
    transition:all .2s ease;
  }
  .cta-ghost:hover{background:var(--ink); color:var(--navy-deep);}

  .mobile-toggle{display:none; flex-direction:column; gap:5px; cursor:pointer; background:none; border:none;}
  .mobile-toggle span{width:24px; height:1.5px; background:var(--ink);}

  /* ===== HERO ===== */
  .hero{padding:88px 0 64px; position:relative; overflow:hidden;}
  .hero-grid{
    display:grid; grid-template-columns:1.1fr .9fr; gap:56px; align-items:center;
  }
  .hero h1{
    font-size:clamp(34px, 4.6vw, 56px); font-weight:600; line-height:1.06; margin:20px 0 22px;
  }
  .hero h1 em{font-style:italic; color:var(--verified);}
  .hero p.lead{font-size:17px; color:var(--ink-70); max-width:480px; margin-bottom:32px;}
  .hero-actions{display:flex; gap:14px; flex-wrap:wrap;}

  .stamp-wrap{display:flex; align-items:center; justify-content:center; position:relative;}
  .stamp{
    width:280px; height:280px; position:relative;
    animation: stamp-in .7s cubic-bezier(.2,.9,.3,1.2) both;
    animation-delay:.15s;
  }
  @keyframes stamp-in{
    from{opacity:0; transform:scale(1.4) rotate(-24deg);}
    to{opacity:1; transform:scale(1) rotate(-9deg);}
  }
  .stamp svg{width:100%; height:100%;}

  .ledger-row{
    margin-top:64px; border-top:1px solid var(--line); border-bottom:1px solid var(--line);
    display:grid; grid-template-columns:repeat(4,1fr);
  }
  .ledger-item{padding:22px 24px; border-left:1px solid var(--line);}
  .ledger-item:first-child{border-left:none; padding-left:0;}
  .ledger-item b{
    font-family:'Fraunces', serif; font-size:32px; font-weight:600; display:block; color:var(--ink);
  }
  .ledger-item span{font-size:12.5px; color:var(--ink-70); letter-spacing:.01em;}

  .hero-banner{margin-top:26px; position:relative; border-radius:4px; overflow:hidden; border:1px solid var(--line); box-shadow:0 20px 40px -24px rgba(0,0,0,.5);}
  .hero-banner svg{width:100%; height:auto; display:block;}
  .hero-banner-cap{position:absolute; left:24px; bottom:18px; font-size:11px;}

  /* ===== SECTION HEADERS ===== */
  section{padding:88px 0;}
  .sec-head{
    display:flex; justify-content:space-between; align-items:flex-end; gap:24px;
    margin-bottom:44px; flex-wrap:wrap;
  }
  .sec-head h2{font-size:clamp(26px,3vw,36px); font-weight:600;}
  .sec-head p{color:var(--ink-70); max-width:420px; font-size:14.5px;}

  /* ===== LAYANAN ===== */
  .layanan-bg{background:var(--navy-deep); border-top:1px solid var(--line); border-bottom:1px solid var(--line);}
  .layanan-grid{
    display:grid; grid-template-columns:repeat(3,1fr); gap:1px; background:var(--line);
    border:1px solid var(--line);
  }
  .layanan-card{
    background:var(--paper); padding:32px 28px; min-height:190px;
    display:flex; flex-direction:column; justify-content:space-between;
    transition:background .2s ease;
  }
  .layanan-card:hover{background:var(--parchment-2);}
  .layanan-top{display:flex; align-items:center; justify-content:space-between;}
  .layanan-icon{width:34px; height:34px; color:var(--verified); flex-shrink:0;}
  .layanan-num{font-family:'IBM Plex Mono',monospace; font-size:12px; color:var(--brass); letter-spacing:.06em;}
  .layanan-card h3{font-size:19px; font-weight:600; margin:14px 0 8px;}
  .layanan-card p{font-size:13.5px; color:var(--ink-70);}

  /* ===== ALUR PENGAWASAN (landscape diagram) ===== */
  .alur-diagram{
    display:grid; grid-template-columns:repeat(5,1fr);
    border:1px solid var(--line); background:var(--paper); overflow-x:auto;
  }
  .alur-step{
    padding:30px 22px; border-right:1px solid var(--line); position:relative;
    display:flex; flex-direction:column; gap:14px; min-width:170px;
  }
  .alur-step:last-child{border-right:none;}
  .alur-step:not(:last-child)::after{
    content:"→"; position:absolute; right:-11px; top:50%; transform:translateY(-50%);
    width:22px; height:22px; background:var(--paper); color:var(--brass);
    display:flex; align-items:center; justify-content:center; font-size:14px; z-index:2;
  }
  .alur-icon{width:30px; height:30px; color:var(--rust);}
  .alur-step .n{font-family:'IBM Plex Mono',monospace; font-size:11px; color:var(--ink-40); letter-spacing:.08em;}
  .alur-step h4{font-family:'Fraunces',serif; font-size:16.5px; font-weight:600;}
  .alur-step p{font-size:12.5px; color:var(--ink-70); line-height:1.45;}

  /* ===== MAJALAH: kartu unggulan landscape ===== */
  .mag-featured{
    grid-column:1 / -1; display:grid; grid-template-columns:1.35fr 1fr;
    border:1px solid var(--line); background:var(--paper); overflow:hidden; margin-bottom:22px;
    transition:box-shadow .25s ease;
  }
  .mag-featured:hover{box-shadow:0 22px 34px -22px rgba(20,33,61,.4);}
  .mag-feat-cover{
    aspect-ratio:16/9; position:relative; overflow:hidden;
    background:linear-gradient(155deg,var(--navy) 0%, #23375c 100%);
  }
  .mag-feat-cover svg{position:absolute; inset:0; width:100%; height:100%; opacity:.5;}
  .mag-feat-tag{
    position:absolute; top:20px; left:20px; font-family:'IBM Plex Mono',monospace;
    font-size:10.5px; letter-spacing:.12em; color:var(--brass-dim); background:rgba(0,0,0,.25);
    padding:5px 10px; border-radius:2px;
  }
  .mag-feat-title{
    position:absolute; left:24px; bottom:22px; right:24px; color:var(--ink);
    font-family:'Fraunces',serif; font-size:clamp(20px,2.2vw,28px); font-weight:600; line-height:1.15;
  }
  .mag-feat-body{padding:28px 30px; display:flex; flex-direction:column; justify-content:center; gap:14px;}
  .mag-feat-body .eyebrow{margin-bottom:0;}
  .mag-feat-body p{font-size:13.5px; color:var(--ink-70); line-height:1.6;}
  .mag-feat-body a{font-size:13px; font-weight:600; color:var(--verified);}
  .mag-cover-pattern{position:absolute; inset:0; width:100%; height:100%; opacity:.35;}

  /* ===== INFO PUBLIK STRIP ===== */
  .index-strip{
    display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:0;
    border-top:1px solid var(--line);
  }
  .index-col{padding:24px 0; border-bottom:1px solid var(--line);}
  .index-col h4{
    font-family:'IBM Plex Mono',monospace; font-size:11.5px; letter-spacing:.1em; text-transform:uppercase;
    color:var(--verified); margin-bottom:14px;
  }
  .index-col a{display:block; font-size:14px; color:var(--ink); padding:6px 0; border-top:1px dotted var(--line);}
  .index-col a:first-of-type{border-top:none;}
  .index-col a:hover{color:var(--rust);}

  /* ===== PUBLIKASI / MAJALAH ===== */
  .majalah-scroll{
    display:grid; grid-template-columns:repeat(4,1fr); gap:22px;
  }
  .mag-card{
    background:var(--paper); border:1px solid var(--line); border-radius:2px;
    overflow:hidden; transition:transform .25s ease, box-shadow .25s ease;
    display:flex; flex-direction:column;
  }
  .mag-card:hover{transform:translateY(-6px); box-shadow:0 18px 30px -18px rgba(20,33,61,.35);}
  .mag-cover{
    aspect-ratio:3/4; background:linear-gradient(155deg,var(--navy) 0%, #23375c 100%);
    position:relative; display:flex; flex-direction:column; justify-content:space-between;
    padding:20px; color:var(--ink);
  }
  .mag-cover::before{
    content:""; position:absolute; left:0; top:0; bottom:0; width:10px;
    background:rgba(0,0,0,.22);
  }
  .mag-cover .ed{font-family:'IBM Plex Mono',monospace; font-size:10.5px; letter-spacing:.1em; opacity:.8;}
  .mag-cover .ti{font-family:'Fraunces',serif; font-size:19px; font-weight:600; line-height:1.15;}
  .mag-info{padding:16px 18px; display:flex; justify-content:space-between; align-items:center;}
  .mag-info span{font-size:12px; color:var(--ink-70);}
  .mag-info a{font-size:12.5px; font-weight:600; color:var(--verified);}

  /* ===== TENTANG ===== */
  .tentang-bg{background:var(--navy-soft); color:var(--ink);}
  .tentang-bg .eyebrow{color:var(--brass);}
  .tentang-bg .eyebrow::before{background:var(--brass);}
  .tentang-grid{display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:start;}
  .tentang-grid h2{color:var(--ink); font-size:clamp(26px,3vw,34px); font-weight:600; margin:16px 0 18px;}
  .tentang-grid p{color:rgba(243,239,228,.72); font-size:15px; max-width:480px;}
  .nilai-list{display:grid; grid-template-columns:1fr 1fr; gap:1px; background:rgba(243,239,228,.16); border:1px solid rgba(243,239,228,.16); margin-top:8px;}
  .nilai-item{padding:22px; background:var(--navy-deep);}
  .nilai-item b{font-family:'Fraunces',serif; font-size:16.5px; font-weight:600; display:block; margin-bottom:6px; color:var(--ink);}
  .nilai-item span{font-size:12.5px; color:rgba(243,239,228,.6);}

  /* ===== FOOTER ===== */
  footer{background:var(--parchment-2); border-top:1px solid var(--line); padding:64px 0 28px;}
  .foot-grid{display:grid; grid-template-columns:1.4fr 1fr 1fr 1fr; gap:40px; padding-bottom:40px;}
  .foot-brand p{font-size:13.5px; color:var(--ink-70); margin-top:14px; max-width:280px;}
  .foot-social{display:flex; gap:10px; margin-top:20px;}
  .foot-social a{
    width:34px; height:34px; border-radius:50%; border:1px solid var(--line);
    display:flex; align-items:center; justify-content:center;
    color:var(--ink-70); transition:all .2s ease;
  }
  .foot-social a:hover{color:var(--ink); border-color:var(--ink); background:rgba(243,239,228,.06);}
  .foot-social svg{width:15px; height:15px;}
  .foot-col h5{font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:.1em; text-transform:uppercase; color:var(--ink-70); margin-bottom:14px;}
  .foot-col a{display:block; font-size:13.5px; padding:5px 0; color:var(--ink);}
  .foot-col a:hover{color:var(--rust);}
  .foot-bottom{
    border-top:1px solid var(--line); padding-top:22px; display:flex; justify-content:space-between;
    font-size:12px; color:var(--ink-70); flex-wrap:wrap; gap:10px;
  }

  /* ===== RESPONSIVE ===== */
  @media (max-width: 920px){
    nav.main-nav, .header-actions{display:none;}
    .mobile-toggle{display:flex;}
    .hero-grid{grid-template-columns:1fr;}
    .stamp-wrap{order:-1;}
    .stamp{width:190px; height:190px;}
    .ledger-row{grid-template-columns:1fr 1fr;}
    .ledger-item{border-left:none !important; border-top:1px solid var(--line);}
    .layanan-grid{grid-template-columns:1fr;}
    .majalah-scroll{grid-template-columns:1fr 1fr; overflow-x:visible;}
    .tentang-grid{grid-template-columns:1fr;}
    .nilai-list{grid-template-columns:1fr 1fr;}
    .foot-grid{grid-template-columns:1fr 1fr; row-gap:32px;}
    .alur-diagram{grid-template-columns:1fr 1fr;}
    .alur-step:not(:last-child)::after{display:none;}
    .mag-featured{grid-template-columns:1fr;}
  }
  @media (max-width: 560px){
    .majalah-scroll{grid-template-columns:1fr;}
    .foot-grid{grid-template-columns:1fr;}
    .alur-diagram{grid-template-columns:1fr;}
  }
</style>
</head>
<body>

<header>
  <div class="wrap nav-row">
    <div class="brand">
      <div class="brand-mark"><img src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat Kota Mojokerto"></div>
      <div class="brand-text">
        <b>INSPEKTORAT</b>
        <span>Aparat Pengawasan Intern</span>
      </div>
    </div>
    <nav class="main-nav">
      <a href="#informasi">Informasi Publik</a>
      <a href="#layanan">Layanan</a>
      <a href="#publikasi">Publikasi</a>
      <a href="#tentang">Tentang Kami</a>
    </nav>
    <div class="header-actions" style="display:flex; gap:10px;">
      <a href="#pengaduan" class="cta-ghost">Masuk PPID</a>
      <a href="#pengaduan" class="cta-btn">Ajukan Pengaduan</a>
    </div>
    <button class="mobile-toggle" aria-label="Menu"><span></span><span></span><span></span></button>
  </div>
</header>

<section class="hero">
  <div class="wrap">
    <div class="hero-grid">
      <div>
        <div class="eyebrow">Laporan Hasil Pengawasan · Terverifikasi</div>
        <h1>Mengawal akuntabilitas, <em>menjaga</em> kepercayaan publik.</h1>
        <p class="lead">Dari anggaran desa hingga proyek strategis daerah — setiap rupiah yang dikelola pemerintah melewati mata kami. Inspektorat menjalankan audit, reviu, evaluasi, dan pemantauan agar program berjalan sesuai aturan, tepat sasaran, dan bisa dipertanggungjawabkan ke publik.</p>
        <div class="hero-actions">
          <a href="#publikasi" class="cta-btn">Lihat Laporan Pengawasan</a>
          <a href="#layanan" class="cta-ghost">Jelajahi Layanan</a>
        </div>
      </div>
      <div class="stamp-wrap">
        <div class="stamp">
          <svg viewBox="0 0 240 240" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <path id="circlePath" d="M 120,120 m -95,0 a 95,95 0 1,1 190,0 a 95,95 0 1,1 -190,0"/>
            </defs>
            <circle cx="120" cy="120" r="112" fill="none" stroke="#A63D2C" stroke-width="2"/>
            <circle cx="120" cy="120" r="95" fill="none" stroke="#A63D2C" stroke-width="1.2"/>
            <circle cx="120" cy="120" r="58" fill="none" stroke="#A63D2C" stroke-width="1.2"/>
            <text font-family="IBM Plex Mono, monospace" font-size="12.5" fill="#A63D2C" letter-spacing="3.5">
              <textPath href="#circlePath" startOffset="2%">TERVERIFIKASI • INSPEKTORAT • PENGAWASAN INTERN •</textPath>
            </text>
            <g transform="translate(120,120)">
              <path d="M -26,-2 L -8,16 L 30,-24" fill="none" stroke="#A63D2C" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
          </svg>
        </div>
      </div>
    </div>

    <div class="ledger-row">
      <div class="ledger-item"><b class="mono">128</b><span>Laporan Hasil Pemeriksaan / Tahun</span></div>
      <div class="ledger-item"><b class="mono">96%</b><span>Tindak Lanjut Rekomendasi</span></div>
      <div class="ledger-item"><b class="mono">42</b><span>Auditor &amp; Pengawas Bersertifikat</span></div>
      <div class="ledger-item"><b class="mono">24J</b><span>Rata-rata Respons Pengaduan</span></div>
    </div>

    <div class="hero-banner">
      <svg viewBox="0 0 1200 260" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
        <rect x="0" y="0" width="1200" height="260" fill="#14213D"/>
        <g opacity="0.9">
          <rect x="60" y="120" width="46" height="110" fill="#1c2f52"/>
          <rect x="115" y="90" width="46" height="140" fill="#233a63"/>
          <rect x="170" y="150" width="46" height="80" fill="#1c2f52"/>
          <rect x="225" y="60" width="46" height="170" fill="#233a63"/>
          <rect x="280" y="110" width="46" height="120" fill="#1c2f52"/>
          <rect x="335" y="40" width="46" height="190" fill="#2b4470"/>
        </g>
        <g stroke="#F3EFE4" stroke-opacity="0.08" stroke-width="1">
          <line x1="0" y1="60" x2="1200" y2="60"/>
          <line x1="0" y1="120" x2="1200" y2="120"/>
          <line x1="0" y1="180" x2="1200" y2="180"/>
        </g>
        <polyline points="60,190 190,150 320,170 450,100 580,120 710,70 840,90 970,45 1100,60" fill="none" stroke="#B8901F" stroke-width="3"/>
        <g fill="#B8901F">
          <circle cx="450" cy="100" r="5"/>
          <circle cx="710" cy="70" r="5"/>
          <circle cx="970" cy="45" r="5"/>
        </g>
        <text x="450" y="86" font-family="IBM Plex Mono, monospace" font-size="12" fill="#F3EFE4" opacity="0.75">Reviu tuntas</text>
        <text x="710" y="56" font-family="IBM Plex Mono, monospace" font-size="12" fill="#F3EFE4" opacity="0.75">Temuan turun 18%</text>
        <text x="900" y="32" font-family="IBM Plex Mono, monospace" font-size="12" fill="#F3EFE4" opacity="0.75">Skor kepatuhan naik</text>
        <g transform="translate(1040,150)" stroke="#A63D2C" stroke-width="4" fill="none" stroke-linecap="round">
          <circle cx="0" cy="0" r="26"/>
          <line x1="19" y1="19" x2="42" y2="42"/>
        </g>
      </svg>
      <div class="hero-banner-cap eyebrow" style="color:var(--brass-dim);">Tren capaian pengawasan lima tahun terakhir</div>
    </div>
  </div>
</section>

<section id="layanan" class="layanan-bg">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="eyebrow">Layanan</div>
        <h2 style="margin-top:14px;">Ruang lingkup pengawasan</h2>
      </div>
      <p>Enam bentuk layanan pengawasan intern yang dijalankan sesuai standar audit internal pemerintah.</p>
    </div>
  </div>
  <div class="wrap" style="padding:0 28px;">
    <div class="layanan-grid">
      <div class="layanan-card">
        <div class="layanan-top">
          <svg class="layanan-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><line x1="16.2" y1="16.2" x2="24" y2="24"/><path d="M8 11h6M11 8v6" stroke-width="1.3"/></svg>
          <span class="layanan-num">01 — AUDIT</span>
        </div>
        <div>
          <h3>Audit Kinerja &amp; Keuangan</h3>
          <p>Menilai efektivitas program dan kewajaran pengelolaan anggaran, dari perencanaan sampai realisasi, di seluruh unit kerja.</p>
        </div>
      </div>
      <div class="layanan-card">
        <div class="layanan-top">
          <svg class="layanan-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="6" y="4" width="14" height="20" rx="1.5"/><path d="M10 11l2.2 2.2L18 8" stroke-width="1.6"/><line x1="9" y1="18" x2="17" y2="18" stroke-width="1.3"/></svg>
          <span class="layanan-num">02 — REVIU</span>
        </div>
        <div>
          <h3>Reviu Laporan &amp; Rencana</h3>
          <p>Menelaah laporan keuangan dan dokumen perencanaan sebelum disahkan, jadi koreksi terjadi di awal — bukan sesudah masalah muncul.</p>
        </div>
      </div>
      <div class="layanan-card">
        <div class="layanan-top">
          <svg class="layanan-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="14" cy="14" r="9"/><circle cx="14" cy="14" r="5"/><circle cx="14" cy="14" r="1.3" fill="currentColor" stroke="none"/></svg>
          <span class="layanan-num">03 — EVALUASI</span>
        </div>
        <div>
          <h3>Evaluasi Program</h3>
          <p>Mengukur capaian dan dampak nyata suatu program terhadap sasaran pembangunan yang telah ditetapkan bersama.</p>
        </div>
      </div>
      <div class="layanan-card">
        <div class="layanan-top">
          <svg class="layanan-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="14" cy="14" r="10"/><path d="M14 14l5.5-3.2" stroke-width="1.8"/><circle cx="14" cy="14" r="1.6" fill="currentColor" stroke="none"/></svg>
          <span class="layanan-num">04 — PEMANTAUAN</span>
        </div>
        <div>
          <h3>Pemantauan Tindak Lanjut</h3>
          <p>Mengawal setiap rekomendasi hasil pemeriksaan sampai benar-benar dijalankan dan hasilnya terverifikasi di lapangan.</p>
        </div>
      </div>
      <div class="layanan-card">
        <div class="layanan-top">
          <svg class="layanan-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M5 6h18v12H12l-4 4v-4H5z" stroke-linejoin="round"/><path d="M10 12l2.3 2.3L18 9" stroke-width="1.6"/></svg>
          <span class="layanan-num">05 — KONSULTASI</span>
        </div>
        <div>
          <h3>Konsultansi &amp; Asistensi</h3>
          <p>Pendampingan langsung bagi unit kerja dalam membangun sistem pengendalian intern yang kokoh sejak awal.</p>
        </div>
      </div>
      <div class="layanan-card">
        <div class="layanan-top">
          <svg class="layanan-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M14 4l9 3.5v6c0 6-4 9.5-9 10.5-5-1-9-4.5-9-10.5v-6L14 4z" stroke-linejoin="round"/><line x1="14" y1="11" x2="14" y2="16" stroke-width="1.8"/><circle cx="14" cy="19" r="1" fill="currentColor" stroke="none"/></svg>
          <span class="layanan-num">06 — PENGADUAN</span>
        </div>
        <div>
          <h3>Pengaduan Masyarakat</h3>
          <p>Menerima dan menindaklanjuti laporan dugaan penyimpangan secara rahasia — identitas pelapor kami lindungi penuh.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="alur-bg">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="eyebrow">Metodologi</div>
        <h2 style="margin-top:14px;">Bagaimana satu pemeriksaan berjalan</h2>
      </div>
      <p>Lima tahap yang selalu dilalui setiap penugasan, dari surat tugas pertama hingga temuan dinyatakan tuntas.</p>
    </div>
    <div class="alur-diagram">
      <div class="alur-step">
        <svg class="alur-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="5" y="4" width="18" height="20" rx="1.5"/><line x1="9" y1="10" x2="19" y2="10"/><line x1="9" y1="14" x2="19" y2="14"/><line x1="9" y1="18" x2="15" y2="18"/></svg>
        <span class="n mono">01</span>
        <h4>Perencanaan</h4>
        <p>Menetapkan objek, ruang lingkup, dan risiko yang jadi fokus pemeriksaan.</p>
      </div>
      <div class="alur-step">
        <svg class="alur-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="7"/><line x1="16.2" y1="16.2" x2="24" y2="24"/></svg>
        <span class="n mono">02</span>
        <h4>Pelaksanaan</h4>
        <p>Mengumpulkan bukti di lapangan: wawancara, uji petik, dan verifikasi dokumen.</p>
      </div>
      <div class="alur-step">
        <svg class="alur-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 22V13M14 22V6M22 22v-9" stroke-linecap="round"/></svg>
        <span class="n mono">03</span>
        <h4>Pelaporan</h4>
        <p>Menyusun simpulan dan rekomendasi dalam Laporan Hasil Pemeriksaan resmi.</p>
      </div>
      <div class="alur-step">
        <svg class="alur-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="14" cy="14" r="10"/><path d="M14 14l5.5-3.2"/></svg>
        <span class="n mono">04</span>
        <h4>Tindak Lanjut</h4>
        <p>Memantau setiap rekomendasi hingga dijalankan oleh unit kerja terkait.</p>
      </div>
      <div class="alur-step">
        <svg class="alur-icon" viewBox="0 0 28 28" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 15l5 5 11-12" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span class="n mono">05</span>
        <h4>Verifikasi Tuntas</h4>
        <p>Status temuan dinyatakan selesai setelah bukti perbaikan diperiksa ulang.</p>
      </div>
    </div>
  </div>
</section>

<section id="informasi">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="eyebrow">Informasi Publik</div>
        <h2 style="margin-top:14px;">Indeks dokumen &amp; keterbukaan</h2>
      </div>
      <p>Akses cepat ke dokumen wajib keterbukaan informasi publik sesuai amanat undang-undang.</p>
    </div>
    <div class="index-strip">
      <div class="index-col">
        <h4>Layanan Informasi</h4>
        <a href="#">Permohonan Informasi Publik</a>
        <a href="#">Daftar Informasi Publik</a>
        <a href="#">Informasi Berkala</a>
        <a href="#">Pengumuman</a>
      </div>
      <div class="index-col">
        <h4>Standar &amp; Kebijakan</h4>
        <a href="#">Maklumat Pelayanan</a>
        <a href="#">Standar Operasional Prosedur</a>
        <a href="#">Kebijakan Anti Korupsi</a>
        <a href="#">Kode Etik Auditor</a>
      </div>
      <div class="index-col">
        <h4>Akuntabilitas</h4>
        <a href="#">Laporan Kinerja</a>
        <a href="#">Perjanjian Kinerja</a>
        <a href="#">Laporan Keuangan</a>
        <a href="#">LHKPN Pejabat</a>
      </div>
      <div class="index-col">
        <h4>Kanal Pengaduan</h4>
        <a href="#">Whistleblowing System</a>
        <a href="#">SP4N LAPOR!</a>
        <a href="#">Survei Kepuasan Masyarakat</a>
        <a href="#">Peta Situs</a>
      </div>
    </div>
  </div>
</section>

<section id="publikasi" class="layanan-bg">
  <div class="wrap">
    <div class="sec-head">
      <div>
        <div class="eyebrow">Publikasi</div>
        <h2 style="margin-top:14px;">Majalah &amp; laporan pengawasan</h2>
      </div>
      <p>Kumpulan edisi majalah internal berisi ulasan hasil audit, opini pengawasan, dan capaian unit kerja.</p>
    </div>
    <div class="majalah-scroll">

      <a href="{{ url('/buletin/edisi-01-2026') }}" class="mag-featured">
        <div class="mag-feat-cover">
          <svg class="mag-cover-pattern" viewBox="0 0 480 270" xmlns="http://www.w3.org/2000/svg">
            <polyline points="0,220 60,190 120,205 180,150 240,170 300,110 360,130 420,80 480,95" fill="none" stroke="#B8901F" stroke-width="3"/>
            <g stroke="#F3EFE4" stroke-opacity="0.15"><line x1="0" y1="60" x2="480" y2="60"/><line x1="0" y1="120" x2="480" y2="120"/><line x1="0" y1="180" x2="480" y2="180"/></g>
          </svg>
          <span class="mag-feat-tag mono">EDISI TERBARU · 01 / 2026</span>
          <span class="mag-feat-title">Reviu Sebelum Realisasi</span>
        </div>
        <div class="mag-feat-body">
          <div class="eyebrow">Laporan Utama</div>
          <p>Bagaimana reviu di awal bisa mencegah temuan yang jauh lebih mahal dikoreksi setelah anggaran cair — lengkap dengan capaian tindak lanjut triwulan ini.</p>
          <span style="font-size:13px; font-weight:600; color:var(--verified);">Baca edisi lengkap ↗</span>
        </div>
      </a>

      <a href="{{ url('/buletin/edisi-24-2025') }}" class="mag-card">
        <div class="mag-cover">
          <svg class="mag-cover-pattern" viewBox="0 0 240 320" xmlns="http://www.w3.org/2000/svg">
            <circle cx="120" cy="130" r="70" fill="none" stroke="#F3EFE4" stroke-opacity="0.25"/>
            <path d="M100 130l15 15 30-32" fill="none" stroke="#B8901F" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="ed mono">EDISI 24 · 2025</span>
          <span class="ti">Tata Garis Tegak Batas Pengawasan</span>
        </div>
        <div class="mag-info"><span>48 hlm</span><span style="font-size:12.5px; font-weight:600; color:var(--verified);">Baca ↗</span></div>
      </a>
      <a href="{{ url('/buletin/edisi-23-2025') }}" class="mag-card">
        <div class="mag-cover">
          <svg class="mag-cover-pattern" viewBox="0 0 240 320" xmlns="http://www.w3.org/2000/svg">
            <line x1="60" y1="250" x2="60" y2="110" stroke="#F3EFE4" stroke-opacity="0.25"/>
            <rect x="70" y="180" width="26" height="70" fill="#B8901F" opacity="0.8"/>
            <rect x="105" y="140" width="26" height="110" fill="#F3EFE4" opacity="0.3"/>
            <rect x="140" y="100" width="26" height="150" fill="#B8901F" opacity="0.5"/>
          </svg>
          <span class="ed mono">EDISI 22 · 2025</span>
          <span class="ti">Reviu Sebagai Rem Awal</span>
        </div>
        <div class="mag-info"><span>40 hlm</span><span style="font-size:12.5px; font-weight:600; color:var(--verified);">Baca ↗</span></div>
      </a>
      <a href="{{ url('/buletin/edisi-22-2025') }}" class="mag-card">
        <div class="mag-cover">
          <svg class="mag-cover-pattern" viewBox="0 0 240 320" xmlns="http://www.w3.org/2000/svg">
            <path d="M60 260 L120 90 L180 260 Z" fill="none" stroke="#F3EFE4" stroke-opacity="0.25" stroke-width="2"/>
            <circle cx="120" cy="150" r="4" fill="#B8901F"/>
          </svg>
          <span class="ed mono">EDISI 21 · 2025</span>
          <span class="ti">Jejak Tindak Lanjut</span>
        </div>
        <div class="mag-info"><span>44 hlm</span><span style="font-size:12.5px; font-weight:600; color:var(--verified);">Baca ↗</span></div>
      </a>
    </div>
    <div style="text-align:center; margin-top:36px;">
      <a href="{{ url('/buletin') }}" class="cta-ghost">Lihat Semua Edisi</a>
    </div>
  </div>
</section>

<section id="tentang" class="tentang-bg">
  <div class="wrap">
    <div class="tentang-grid">
      <div>
        <div class="eyebrow">Tentang Kami</div>
        <h2>Aparat pengawasan intern yang independen dan profesional.</h2>
        <p>Inspektorat berkedudukan langsung di bawah pimpinan daerah dan bertugas membantu pengawasan penyelenggaraan pemerintahan, memastikan tata kelola berjalan bersih, efektif, dan akuntabel bagi masyarakat.</p>
        <svg width="120" height="70" viewBox="0 0 120 70" style="margin-top:26px; opacity:.85;">
          <path d="M60 4l50 19v14c0 22-20 33-50 33S10 59 10 37V23L60 4z" fill="none" stroke="#B8901F" stroke-width="1.6"/>
          <path d="M42 36l12 12 24-26" fill="none" stroke="#F3EFE4" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div>
        <div class="nilai-list">
          <div class="nilai-item"><b>Integritas</b><span>Konsisten antara pikiran, ucapan, dan tindakan.</span></div>
          <div class="nilai-item"><b>Independensi</b><span>Bebas dari intervensi dalam setiap pemeriksaan.</span></div>
          <div class="nilai-item"><b>Profesionalisme</b><span>Bekerja sesuai standar audit yang berlaku.</span></div>
          <div class="nilai-item"><b>Akuntabel</b><span>Bertanggung jawab atas setiap simpulan hasil audit.</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <div class="brand">
          <div class="brand-mark"><img src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat Kota Mojokerto"></div>
          <div class="brand-text"><b>INSPEKTORAT</b><span>Pengawasan Intern Pemerintah</span></div>
        </div>
        <p>Portal resmi layanan pengawasan, informasi publik, dan pengaduan masyarakat.</p>
        <div class="foot-social">
          <a href="#" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 4h-2a4 4 0 0 0-4 4v2H7v3h2v7h3v-7h2.5l.5-3H12V8a1 1 0 0 1 1-1h2V4z"/></svg>
          </a>
          <a href="#" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
          </a>
          <a href="#" aria-label="YouTube">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2.5" y="6" width="19" height="12" rx="3"/><path d="M10.5 9.5l5 2.5-5 2.5z" fill="currentColor" stroke="none"/></svg>
          </a>
        </div>
      </div>
      <div class="foot-col">
        <h5>Layanan</h5>
        <a href="#layanan">Audit &amp; Reviu</a>
        <a href="#layanan">Evaluasi Program</a>
        <a href="#layanan">Pengaduan Masyarakat</a>
      </div>
      <div class="foot-col">
        <h5>Publikasi</h5>
        <a href="{{ url('/buletin') }}">Majalah Pengawasan</a>
        <a href="#informasi">Laporan Kinerja</a>
        <a href="#informasi">Laporan Keuangan</a>
      </div>
      <div class="foot-col">
        <h5>Kontak</h5>
        <a href="#">Jl. Pengawasan No. 1, Kota</a>
        <a href="tel:0000000000">(021) 000-0000</a>
        <a href="mailto:inspektorat@pemda.go.id">inspektorat@pemda.go.id</a>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© 2026 Inspektorat. Seluruh hak cipta dilindungi.</span>
      <span class="mono">Portal Resmi Pengawasan Intern</span>
    </div>
  </div>
</footer>

<script>
  document.querySelector('.mobile-toggle').addEventListener('click', function(){
    const nav = document.querySelector('.main-nav');
    const actions = document.querySelector('.header-actions');
    const open = nav.style.display === 'flex';
    nav.style.cssText = open ? '' : 'display:flex; flex-direction:column; position:absolute; top:76px; left:0; right:0; background:#F3EFE4; padding:20px 28px; gap:18px; border-bottom:1px solid rgba(20,33,61,.14);';
    actions.style.cssText = open ? '' : 'display:flex; flex-direction:column; position:absolute; top:auto; margin-top:225px; left:0; right:0; background:#F3EFE4; padding:0 28px 20px; gap:10px;';
  });
</script>

</body>
</html>