{{--
  resources/views/buletin/show.blade.php
  Reader "buku terbuka" per edisi. Halaman sampul tampil SENDIRIAN (1 halaman
  penuh, seperti membuka sampul buku), baru halaman berikutnya tampil
  berpasangan 2-2 (spread) seperti buku yang sudah terbuka.
  Data edisi ($current, $totalPages) dikirim dari routes/web.php.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $current['title'] }} — Buletin Pengawasan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,500;1,9..144,600&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --navy:#0B2A4A; --navy-deep:#06182E; --navy-soft:#12335A;
    --ink:#F3EFE4; --ink-70:rgba(243,239,228,.72); --ink-40:rgba(243,239,228,.42);
    --parchment:#F3EFE4; --parchment-2:#EAE3D2; --paper:#FBF9F3;
    --verified:#2F6F4E; --brass:#B8901F; --brass-dim:#EFE3C4; --rust:#A63D2C;
    --line: rgba(20,33,61,.14);
    --stage: var(--navy-deep);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{background:var(--stage); color:var(--ink); font-family:'IBM Plex Sans',sans-serif; line-height:1.5; overflow-x:hidden;}
  a{color:inherit; text-decoration:none;}
  .mono{font-family:'IBM Plex Mono',monospace;}
  h1,h2,h3{font-family:'Fraunces',serif; letter-spacing:-.01em;}
  button{font-family:inherit;}

  .leaf{ color:#0B2A4A; }
  .leaf .ink-light{ color:#0B2A4A; }

  /* ===== BREADCRUMB ===== */
  .breadcrumb{
    background:var(--navy-deep); padding:8px 26px;
    font-family:'IBM Plex Mono',monospace; font-size:11px;
    color:rgba(243,239,228,.5); display:flex; align-items:center; gap:6px;
  }
  .breadcrumb a:hover{ color:var(--parchment); }
  .breadcrumb .sep{ color:rgba(243,239,228,.25); }
  .breadcrumb .current{ color:var(--brass); }

  /* ===== TOPBAR ===== */
  .reader-topbar{
    background:var(--navy); color:var(--ink);
    display:flex; align-items:center; justify-content:space-between;
    padding:14px 26px; flex-wrap:wrap; gap:10px;
    border-bottom:1px solid rgba(243,239,228,.12);
  }
  .back-link{display:flex; align-items:center; gap:8px; font-size:13px; font-weight:500; color:rgba(243,239,228,.8);}
  .back-link:hover{color:#fff;}
  .back-link svg{width:15px; height:15px;}
  .topbar-title{font-family:'Fraunces',serif; font-size:15px; font-weight:600; text-align:center; flex:1; min-width:160px;}
  .topbar-title span{display:block; font-family:'IBM Plex Mono',monospace; font-size:10px; letter-spacing:.1em; color:var(--brass-dim); text-transform:uppercase; margin-top:2px; font-weight:400;}
  .dl-btn{background:var(--rust); color:#fff; font-size:12.5px; font-weight:600; padding:8px 14px; border-radius:3px; display:flex; align-items:center; gap:7px; border:1px solid var(--rust);}
  .dl-btn:hover{background:#8c3122;}
  .dl-btn svg{width:13px; height:13px;}

  /* ===== STAGE ===== */
  .stage{
    position:relative; min-height:calc(100vh - 60px);
    display:flex; align-items:center; justify-content:center;
    padding:50px 90px 100px;
    background:radial-gradient(ellipse at 50% 35%, var(--navy-soft) 0%, var(--navy-deep) 72%);
    perspective:2200px;
  }

  #zoomWrap{ width:100%; max-width:920px; }
  #spreadWrap{ width:100%; transform-style:preserve-3d; }

  .flip-page{
    position:absolute; z-index:30; pointer-events:none;
    background:linear-gradient(100deg, #ffffff 0%, #f6f1e6 55%, #e8e1d0 100%);
    border-radius:2px; box-shadow:0 10px 30px rgba(0,0,0,.45);
    transform-style:preserve-3d;
    will-change:transform;
  }
  .flip-page::after{
    content:""; position:absolute; inset:0;
    background:linear-gradient(90deg, rgba(0,0,0,.14), transparent 30%, transparent 70%, rgba(0,0,0,.14));
    pointer-events:none;
  }

  .stage-nav{
    position:absolute; top:50%; transform:translateY(-50%);
    width:44px; height:44px; border-radius:50%;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.14);
    color:rgba(243,239,228,.85); display:flex; align-items:center; justify-content:center;
    cursor:pointer; transition:background .2s ease;
  }
  .stage-nav:hover{background:rgba(255,255,255,.14);}
  .stage-nav:disabled{opacity:.25; cursor:default;}
  .stage-nav svg{width:20px; height:20px;}
  .stage-nav.left{left:26px;}
  .stage-nav.right{right:26px;}

  /* ---- VIEW (spread biasa = 2 halaman) ---- */
  .view{
    display:flex; box-shadow:0 40px 90px -30px rgba(0,0,0,.75);
    max-width:920px; width:100%;
  }
  /* ---- VIEW tunggal (cover) = 1 halaman ---- */
  .view.single{
    max-width:460px; margin:0 auto;
  }
  .view.single .leaf{
    width:100%; border-radius:6px; aspect-ratio:3/4;
  }
  .view.single .leaf::after{ display:none; }

  .leaf{
    background:var(--paper); width:50%; aspect-ratio:3/4;
    padding:36px 34px; position:relative; overflow:hidden;
    display:flex; flex-direction:column;
  }
  .leaf.left-page{border-radius:3px 0 0 3px;}
  .leaf.right-page{border-radius:0 3px 3px 0; border-left:1px solid rgba(20,33,61,.08);}
  .leaf.left-page::after{content:""; position:absolute; right:0; top:0; bottom:0; width:24px; background:linear-gradient(90deg, transparent, rgba(20,33,61,.08));}
  .leaf.right-page::after{content:""; position:absolute; left:0; top:0; bottom:0; width:24px; background:linear-gradient(270deg, transparent, rgba(20,33,61,.08));}
  .page-idx{position:absolute; bottom:16px; font-family:'IBM Plex Mono',monospace; font-size:10.5px; color:rgba(20,33,61,.4);}
  .leaf.left-page .page-idx{left:26px;}
  .leaf.right-page .page-idx{right:26px;}
  .view.single .page-idx{ left:50%; transform:translateX(-50%); }

  .leaf.dark{ background:var(--navy); color:var(--ink); }
  .leaf.dark .page-idx{ color:rgba(243,239,228,.4); }

  .cov{ text-align:center; display:flex; flex-direction:column; justify-content:flex-start; align-items:center; height:100%; position:relative; z-index:1; padding-top:26%; }
  .cov .logo-img{ width:150px; height:auto; margin:0 0 22px; display:block; }
  .cov .eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:10px; letter-spacing:.16em; color:var(--brass); text-transform:uppercase; margin-bottom:12px;}
  .cov h1{ font-size:24px; font-weight:700; color:var(--ink); line-height:1.16;}
  .cov .edisi{ margin-top:22px; font-family:'IBM Plex Mono',monospace; font-size:10.5px; letter-spacing:.08em; color:rgba(243,239,228,.65); border-top:1px solid rgba(243,239,228,.2); padding-top:10px;}

  /* ---- dekorasi cover ---- */
  .cov-bg{ position:absolute; inset:0; z-index:0; }
  .cov-corner{ position:absolute; width:30px; height:30px; border:1.5px solid rgba(184,144,31,.55); z-index:1; }
  .cov-corner.tl{ top:22px; left:22px; border-right:none; border-bottom:none; }
  .cov-corner.br{ bottom:22px; right:22px; border-left:none; border-top:none; }
  .cov-vert{
    position:absolute; top:44px; bottom:44px; z-index:1;
    font-family:'IBM Plex Mono',monospace; font-size:9px; letter-spacing:.32em;
    text-transform:uppercase; color:rgba(243,239,228,.32); writing-mode:vertical-rl;
    display:flex; align-items:center;
  }
  .cov-vert.left{ left:16px; }
  .cov-vert.right{ right:16px; transform:rotate(180deg); }
  .cov .edisi::before{ content:"◆"; display:block; font-size:7px; color:var(--brass); margin-bottom:8px; }

  .photo-panel{ position:relative; width:100%; height:100%; overflow:hidden; }
  .photo-panel svg{ position:absolute; inset:0; width:100%; height:100%; }
  .photo-cap{ position:absolute; left:18px; bottom:18px; right:18px; font-family:'IBM Plex Mono',monospace; font-size:9.5px; letter-spacing:.06em; color:rgba(255,255,255,.75); text-transform:uppercase; }

  /* ---- EDITOR'S NOTE ---- */
  .note-page{ justify-content:flex-start; }
  .note-eyebrow{
    font-family:'IBM Plex Mono',monospace; font-size:9.5px; letter-spacing:.22em;
    text-transform:uppercase; color:var(--brass); margin-bottom:6px;
  }
  .note-head{
    font-family:'Fraunces',serif; font-style:italic; font-weight:600;
    font-size:25px; color:var(--rust); line-height:1.1;
    position:relative; padding-bottom:14px; margin-bottom:16px;
  }
  .note-head::after{
    content:""; position:absolute; left:0; bottom:0; width:52px; height:2px;
    background:var(--brass);
  }
  .note-page p{ font-size:11.5px; color:rgba(20,33,61,.75); text-align:justify; line-height:1.7; margin-bottom:11px; }
  .note-page p.lead::first-letter{
    font-family:'Fraunces',serif; font-weight:700; font-size:40px; float:left;
    line-height:.78; padding:5px 7px 0 0; color:var(--rust);
  }
  .note-sign{
    margin-top:auto; padding-top:14px; border-top:1px solid rgba(20,33,61,.14);
    font-family:'Fraunces',serif; font-style:italic; font-weight:600; font-size:12.5px; color:#0B2A4A;
  }
  .note-sign span{
    display:block; font-family:'IBM Plex Mono',monospace; font-style:normal;
    font-size:9px; letter-spacing:.1em; text-transform:uppercase; color:rgba(20,33,61,.5); margin-top:3px;
  }

  .toc .vert{
    writing-mode:vertical-rl; transform:rotate(180deg); font-family:'Fraunces',serif;
    font-size:24px; font-weight:700; letter-spacing:.02em; color:var(--brass);
    position:absolute; left:28px; top:34px; bottom:34px;
  }
  .toc-list{ margin-left:56px; display:flex; flex-direction:column; gap:0; height:100%; justify-content:center; }
  .toc-row{ display:flex; align-items:baseline; gap:12px; padding:8px 0; border-bottom:1px dotted rgba(20,33,61,.14); }
  .toc-row .no{ font-family:'IBM Plex Mono',monospace; font-size:11.5px; color:var(--brass); width:22px; flex-shrink:0;}
  .toc-row .t{ font-size:11.5px; font-weight:600; line-height:1.3; color:#0B2A4A;}

  .kicker{ font-family:'IBM Plex Mono',monospace; font-size:10px; letter-spacing:.14em; color:var(--rust); text-transform:uppercase;}
  .art h2{ font-size:18px; margin:10px 0 12px; line-height:1.2; color:#0B2A4A;}
  .art p{ font-size:11.5px; color:rgba(20,33,61,.7); margin-bottom:10px; text-align:justify;}
  .art .pull{ border-left:3px solid var(--brass); padding:2px 0 2px 14px; margin:14px 0; font-family:'Fraunces',serif; font-style:italic; font-size:12.5px; color:#0B2A4A;}

  .bars{ margin-top:18px; display:flex; flex-direction:column; gap:13px; }
  .bar-row{ display:flex; align-items:center; gap:10px; }
  .bar-label{ width:104px; font-size:10px; color:rgba(20,33,61,.7); flex-shrink:0;}
  .bar-track{ flex:1; height:8px; background:#EAE3D2; border-radius:2px; overflow:hidden;}
  .bar-fill{ height:100%; }
  .bar-fill.brass{ background:var(--brass); }
  .bar-fill.rust{ background:var(--rust); }
  .bar-val{ width:34px; text-align:right; font-family:'IBM Plex Mono',monospace; font-size:10.5px; color:#0B2A4A;}

  .who{ margin-top:auto; padding-top:14px; border-top:1px solid rgba(20,33,61,.14); font-family:'IBM Plex Mono',monospace; font-size:10.5px; color:var(--verified);}

  .big-quote{ height:100%; display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center; }
  .big-quote .qmark{ font-family:'Fraunces',serif; font-size:58px; color:var(--brass); line-height:1; margin-bottom:8px; }
  .big-quote blockquote{ font-family:'Fraunces',serif; font-style:italic; font-weight:600; font-size:20px; line-height:1.45; color:#0B2A4A; max-width:92%; }
  .big-quote .src{ margin-top:20px; font-family:'IBM Plex Mono',monospace; font-size:10px; letter-spacing:.1em; text-transform:uppercase; color:rgba(20,33,61,.45); }

  .masthead{ height:100%; display:flex; flex-direction:column; }
  .masthead h3{ font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:.14em; text-transform:uppercase; color:var(--verified); margin-bottom:6px;}
  .masthead .hint{ font-size:10px; color:rgba(20,33,61,.45); margin-bottom:18px; }
  .masthead .row{ display:flex; justify-content:space-between; gap:10px; padding:7px 0; border-top:1px dotted rgba(20,33,61,.14); font-size:10.5px;}
  .masthead .row:first-child{ border-top:none; }
  .masthead .role{ color:rgba(20,33,61,.55);}
  .masthead .name{ font-weight:600; color:#0B2A4A; text-align:right;}
  .masthead .foot{ margin-top:auto; padding-top:14px; font-size:9.5px; color:rgba(20,33,61,.45); border-top:1px solid rgba(20,33,61,.14);}

  .closing-page{ height:100%; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; }
  .closing-page h2{ font-size:19px; margin-bottom:12px; color:var(--ink);}
  .closing-page p{ font-size:11.5px; color:rgba(243,239,228,.7); margin-bottom:20px; max-width:85%;}
  .closing-page a.btn{ font-family:'IBM Plex Mono',monospace; font-size:11px; font-weight:600; border:1px solid rgba(243,239,228,.35); padding:9px 18px; border-radius:4px; color:var(--ink);}
  .closing-page a.btn:hover{ background:rgba(243,239,228,.08); }
  .closing-page .qr{ width:60px; height:60px; margin-top:22px; opacity:.55; }

  .ctrl-bar{
    position:fixed; left:50%; bottom:26px; transform:translateX(-50%);
    background:rgba(20,20,22,.9); backdrop-filter:blur(6px);
    border:1px solid rgba(255,255,255,.1); border-radius:30px;
    padding:8px 10px; display:flex; align-items:center; gap:4px; z-index:20;
  }
  .ctrl-btn{ width:34px; height:34px; border-radius:50%; background:transparent; border:none; color:rgba(243,239,228,.8); display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background .2s ease; }
  .ctrl-btn:hover{ background:rgba(255,255,255,.1); }
  .ctrl-btn:disabled{ opacity:.3; cursor:default; }
  .ctrl-btn svg{ width:16px; height:16px; }
  .ctrl-page{ font-family:'IBM Plex Mono',monospace; font-size:12px; color:rgba(243,239,228,.9); padding:0 12px; white-space:nowrap; }
  .ctrl-sep{ width:1px; height:20px; background:rgba(255,255,255,.14); margin:0 6px; }

  /* ===== WIDGET AKSESIBILITAS ===== */
  :root{ --a11y-blue:#2A5CE6; }
  .a11y-btn{
    position:fixed; left:20px; bottom:26px; z-index:60;
    width:48px; height:48px; border-radius:50%;
    background:var(--a11y-blue); color:#fff; border:none; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 10px 24px rgba(0,0,0,.4);
  }
  .a11y-btn svg{ width:23px; height:23px; }
  .a11y-panel{
    position:fixed; left:20px; bottom:82px; z-index:61;
    width:290px; max-width:calc(100vw - 40px);
    background:#fff; border-radius:10px; overflow:hidden;
    box-shadow:0 24px 60px rgba(0,0,0,.45);
    display:none; flex-direction:column;
    font-family:'IBM Plex Sans',sans-serif; color:#14213D;
  }
  .a11y-panel.open{ display:flex; }
  .a11y-head{
    background:var(--a11y-blue); color:#fff; padding:14px 16px;
    display:flex; align-items:center; justify-content:space-between; gap:10px;
    font-size:12.5px; font-weight:600;
  }
  .a11y-head button{ background:none; border:none; color:#fff; cursor:pointer; display:flex; flex-shrink:0; }
  .a11y-head button svg{ width:17px; height:17px; }
  .a11y-body{ padding:14px; }
  .a11y-grid{ display:grid; grid-template-columns:1fr 1fr; gap:10px; }
  .a11y-item{
    background:#F5F5F5; border:1.5px solid transparent; border-radius:8px;
    padding:14px 8px; display:flex; flex-direction:column; align-items:center; gap:8px;
    cursor:pointer; font-size:10.5px; font-weight:600; text-align:center; color:#14213D;
    transition:all .15s ease;
  }
  .a11y-item svg{ width:21px; height:21px; }
  .a11y-item:hover{ background:#ECECEC; }
  .a11y-item.active{ border-color:var(--a11y-blue); background:#fff; }
  .a11y-reset{
    width:100%; margin-top:12px; padding:9px; border-radius:6px; border:1px solid var(--line);
    background:none; font-size:11px; font-weight:600; color:var(--a11y-blue); cursor:pointer;
  }
  .a11y-reset:hover{ background:#eef2fd; }

  /* efek yang benar-benar diterapkan ke halaman */
  html.a11y-contrast body{ filter:contrast(1.35) brightness(1.05); }
  html.a11y-links a{ outline:2px solid var(--a11y-blue) !important; background:#fff59d !important; color:#14213D !important; }
  html.a11y-bigtext{ font-size:118%; }
  html.a11y-spacing body{ letter-spacing:.03em; line-height:1.9; }
  html.a11y-noanim *{ animation-duration:.001s !important; animation-delay:0s !important; transition-duration:.001s !important; }
  html.a11y-noimages img,
  html.a11y-noimages .photo-panel svg,
  html.a11y-noimages .cov-bg{ visibility:hidden !important; }

  @media (max-width:860px){
    .stage{ padding:30px 16px 110px; }
    .stage-nav{ width:36px; height:36px; }
    .stage-nav.left{ left:6px; } .stage-nav.right{ right:6px; }
    .view{ max-width:100%; }
    .leaf{ padding:22px 18px; }
    .cov h1{ font-size:18px; }
    .toc .vert{ font-size:17px; left:14px; }
    .toc-list{ margin-left:34px; }
    .art h2{ font-size:14px; }
  }
  @media (max-width:640px){
    .view:not(.single){ flex-direction:column; }
    .view:not(.single) .leaf{ width:100%; aspect-ratio:auto; min-height:64vh; }
    .leaf.left-page::after, .leaf.right-page::after{ display:none; }
    .view.single{ max-width:92vw; }
  }
</style>
</head>
<body>

<div class="breadcrumb">
  <a href="{{ url('/') }}">Beranda</a>
  <span class="sep">/</span>
  <a href="{{ route('buletin.index') }}">Publikasi</a>
  <span class="sep">/</span>
  <span class="current">{{ $current['title'] }}</span>
</div>

<div class="reader-topbar">
  <a href="{{ route('buletin.index') }}" class="back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    Kembali ke Publikasi
  </a>
  <div class="topbar-title">
    {{ $current['title'] }}
    <span>{{ $current['label'] }}</span>
  </div>
  <a href="#" class="dl-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16"/></svg>
    Unduh PDF
  </a>
</div>

<div class="stage" id="stage">
  <button class="stage-nav left" id="prevBtn" aria-label="Sebelumnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
  </button>

  <div id="zoomWrap">
  <div id="spreadWrap">

    {{-- HALAMAN 01 — Cover (tunggal, tidak dibelah) --}}
    <div class="view single" data-pages="1">
      <div class="leaf dark">
        <div class="cov-bg">
          <svg viewBox="0 0 460 640" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <radialGradient id="covGlow" cx="50%" cy="34%" r="55%">
                <stop offset="0%" stop-color="#B8901F" stop-opacity="0.32"/>
                <stop offset="55%" stop-color="#B8901F" stop-opacity="0.08"/>
                <stop offset="100%" stop-color="#B8901F" stop-opacity="0"/>
              </radialGradient>
            </defs>
            <rect width="460" height="640" fill="url(#covGlow)"/>
            <g stroke="#F3EFE4" stroke-opacity="0.055" stroke-width="1">
              <line x1="0" y1="130" x2="460" y2="130"/>
              <line x1="0" y1="260" x2="460" y2="260"/>
              <line x1="0" y1="390" x2="460" y2="390"/>
              <line x1="0" y1="520" x2="460" y2="520"/>
              <line x1="115" y1="0" x2="115" y2="640"/>
              <line x1="230" y1="0" x2="230" y2="640"/>
              <line x1="345" y1="0" x2="345" y2="640"/>
            </g>
          </svg>
        </div>
        <div class="cov-corner tl"></div>
        <div class="cov-corner br"></div>
        <div class="cov-vert left">Buletin Pengawasan</div>
        <div class="cov-vert right">Inspektorat Kota Mojokerto</div>
        <div class="cov">
          <img class="logo-img" src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat Kota Mojokerto">
          <div class="eyebrow">Terverifikasi</div>
          <h1>{{ $current['title'] }}</h1>
          <div class="edisi">{{ $current['label'] }}</div>
        </div>
        <span class="page-idx">01</span>
      </div>
    </div>

    {{-- SPREAD — 02 Editor's Note | 03 Daftar Isi --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page note-page">
        <div class="note-eyebrow">Sapaan Pembuka</div>
        <div class="note-head">Editor&rsquo;s Note</div>
        <p class="lead">{{ $current['intro'] }}</p>
        <p>Setiap edisi Buletin Pengawasan kami susun untuk menjembatani jarak antara proses pemeriksaan yang teknis dengan hak masyarakat untuk tahu. Kami percaya transparansi bukan sekadar kewajiban administratif, melainkan bentuk tanggung jawab moral kepada publik yang kami layani sehari-hari.</p>
        <p>Selamat membaca, dan semoga edisi ini memberi gambaran yang jernih atas apa yang sedang kami kerjakan di balik meja audit.</p>
        <div class="note-sign">Redaksi Buletin Pengawasan<span>Inspektorat Kota Mojokerto</span></div>
        <span class="page-idx">02</span>
      </div>
      <div class="leaf right-page toc">
        <div class="vert">CONTENTS</div>
        <div class="toc-list">
          @foreach ($current['toc'] as $row)
            <div class="toc-row"><span class="no mono">{{ $row['no'] }}</span><span class="t">{{ $row['t'] }}</span></div>
          @endforeach
        </div>
        <span class="page-idx">03</span>
      </div>
    </div>

    {{-- SPREAD — 04 Foto | 05 Artikel Utama --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#23375c"/><stop offset="1" stop-color="#0B2A4A"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g1)"/>
            <g opacity="0.85">
              <rect x="30" y="230" width="26" height="130" fill="#1c2f52"/>
              <rect x="62" y="190" width="26" height="170" fill="#233a63"/>
              <rect x="94" y="250" width="26" height="110" fill="#1c2f52"/>
              <rect x="126" y="150" width="26" height="210" fill="#2b4470"/>
            </g>
            <circle cx="245" cy="90" r="30" fill="#B8901F" opacity="0.85"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">04</span>
      </div>
      <div class="leaf right-page art">
        <span class="kicker">{{ $current['art_kicker'] }}</span>
        <h2>{{ $current['art_title'] }}</h2>
        <p>{{ $current['art_p1'] }}</p>
        <p class="pull">{{ $current['art_pull'] }}</p>
        <p>{{ $current['art_p2'] }}</p>
        <span class="page-idx">05</span>
      </div>
    </div>

    {{-- SPREAD — 06 Foto | 07 Infografis / Sorotan --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g3" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#5b3a1a"/><stop offset="1" stop-color="#0B2A4A"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g3)"/>
            <path d="M0 260 L60 210 L110 250 L170 160 L230 200 L300 120 L300 400 L0 400 Z" fill="#1c2f52" opacity="0.7"/>
            <path d="M0 300 L80 260 L150 300 L220 240 L300 280 L300 400 L0 400 Z" fill="#0B2A4A" opacity="0.85"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">06</span>
      </div>
      <div class="leaf right-page">
        <span class="kicker" style="color:var(--verified);">Sorotan</span>
        <h2 style="font-size:18px; margin:10px 0 4px;">{{ $current['stats_title'] }}</h2>
        <div class="bars">
          @foreach ($current['stats'] as $s)
            <div class="bar-row">
              <span class="bar-label">{{ $s['label'] }}</span>
              <div class="bar-track"><div class="bar-fill {{ $s['color'] }}" style="width:{{ $s['value'] }}%"></div></div>
              <span class="bar-val mono">{{ $s['value'] }}%</span>
            </div>
          @endforeach
        </div>
        <p style="margin-top:16px; font-size:11px; color:rgba(20,33,61,.7);">{{ $current['stats_note'] }}</p>
        <span class="page-idx">07</span>
      </div>
    </div>

    {{-- SPREAD — 08 Wawancara | 09 Refleksi Lapangan (foto) --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker">Wawancara</span>
        <h2 style="font-size:16px; margin:8px 0 12px;">{{ $current['iv_title'] }}</h2>
        <p style="font-size:11.5px; font-weight:600; margin-bottom:4px; color:#0B2A4A;">{{ $current['iv_q'] }}</p>
        <p style="font-size:11.5px; color:rgba(20,33,61,.7); margin-bottom:10px;">{{ $current['iv_a'] }}</p>
        <div class="who">— {{ $current['iv_who'] }}</div>
        <span class="page-idx">08</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g4" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#0B2A4A"/><stop offset="1" stop-color="#2b4470"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g4)"/>
            <g stroke="#F3EFE4" stroke-opacity="0.18" stroke-width="1.5">
              <line x1="0" y1="90" x2="300" y2="90"/>
              <line x1="0" y1="190" x2="300" y2="190"/>
              <line x1="0" y1="290" x2="300" y2="290"/>
            </g>
            <polyline points="20,300 80,250 130,280 180,190 230,220 300,140" fill="none" stroke="#B8901F" stroke-width="4"/>
            <circle cx="230" cy="220" r="6" fill="#B8901F"/>
            <circle cx="300" cy="140" r="6" fill="#B8901F"/>
          </svg>
          <span class="photo-cap">Refleksi Lapangan</span>
        </div>
        <span class="page-idx">09</span>
      </div>
    </div>

    {{-- SPREAD — 10 Kutipan Besar | 11 Foto --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <div class="big-quote">
          <div class="qmark">&ldquo;</div>
          <blockquote>{{ $current['art_pull'] }}</blockquote>
          <div class="src mono">{{ $current['label'] }}</div>
        </div>
        <span class="page-idx">10</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g2" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#3a5a8f"/><stop offset="1" stop-color="#0B2A4A"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g2)"/>
            <circle cx="150" cy="150" r="70" fill="none" stroke="#F3EFE4" stroke-opacity="0.25" stroke-width="2"/>
            <path d="M125 150l17 17 34-36" fill="none" stroke="#B8901F" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">11</span>
      </div>
    </div>

    {{-- SPREAD — 12 Ringkasan Eksekutif | 13 Foto --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker" style="color:var(--verified);">Ringkasan Eksekutif</span>
        <h2 style="font-size:17px; margin:10px 0 14px;">Inti Edisi Ini</h2>
        <p>{{ Str::limit($current['art_p1'], 140) }}</p>
        <p>{{ Str::limit($current['art_p2'], 140) }}</p>
        <div class="pull" style="font-size:12px;">{{ Str::limit($current['art_pull'], 90) }}</div>
        <span class="page-idx">12</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g5" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#233a63"/><stop offset="1" stop-color="#06182E"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g5)"/>
            <g stroke="#B8901F" stroke-opacity="0.5" stroke-width="1.5">
              <circle cx="150" cy="180" r="90"/>
              <circle cx="150" cy="180" r="55"/>
            </g>
            <circle cx="150" cy="180" r="6" fill="#B8901F"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">13</span>
      </div>
    </div>

    {{-- SPREAD — 14 Profil Singkat | 15 Nilai-Nilai --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker">Profil Singkat</span>
        <h2 style="font-size:16px; margin:8px 0 12px;">Inspektorat Kota Mojokerto</h2>
        <p>Aparat pengawasan intern yang independen dan profesional, berkedudukan langsung di bawah pimpinan daerah. Bertugas membantu pengawasan penyelenggaraan pemerintahan, memastikan tata kelola berjalan bersih, efektif, dan akuntabel bagi masyarakat.</p>
        <span class="page-idx">14</span>
      </div>
      <div class="leaf right-page">
        <span class="kicker" style="color:var(--verified);">Nilai-Nilai Kami</span>
        <div class="bars" style="margin-top:14px;">
          <div style="margin-bottom:14px;"><b style="font-family:'Fraunces',serif; font-size:13px; color:#0B2A4A;">Integritas</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:2px;">Konsisten antara pikiran, ucapan, dan tindakan.</p></div>
          <div style="margin-bottom:14px;"><b style="font-family:'Fraunces',serif; font-size:13px; color:#0B2A4A;">Independensi</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:2px;">Bebas dari intervensi dalam setiap pemeriksaan.</p></div>
          <div style="margin-bottom:14px;"><b style="font-family:'Fraunces',serif; font-size:13px; color:#0B2A4A;">Profesionalisme</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:2px;">Bekerja sesuai standar audit yang berlaku.</p></div>
          <div><b style="font-family:'Fraunces',serif; font-size:13px; color:#0B2A4A;">Akuntabel</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:2px;">Bertanggung jawab atas setiap simpulan hasil audit.</p></div>
        </div>
        <span class="page-idx">15</span>
      </div>
    </div>

    {{-- SPREAD — 16 Alur Pemeriksaan | 17 Foto --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker">Metodologi</span>
        <h2 style="font-size:16px; margin:8px 0 14px;">Alur Satu Pemeriksaan</h2>
        <div class="masthead" style="gap:0;">
          <div class="row"><span class="role">01 · Perencanaan</span><span class="name" style="text-align:left; font-weight:500; color:rgba(20,33,61,.65);"></span></div>
          <p style="font-size:10px; color:rgba(20,33,61,.6); padding:2px 0 8px;">Menetapkan objek, ruang lingkup, dan risiko yang jadi fokus.</p>
          <div class="row"><span class="role">02 · Pelaksanaan</span></div>
          <p style="font-size:10px; color:rgba(20,33,61,.6); padding:2px 0 8px;">Mengumpulkan bukti: wawancara, uji petik, verifikasi dokumen.</p>
          <div class="row"><span class="role">03 · Pelaporan</span></div>
          <p style="font-size:10px; color:rgba(20,33,61,.6); padding:2px 0 8px;">Menyusun simpulan dan rekomendasi dalam LHP resmi.</p>
          <div class="row"><span class="role">04 · Tindak Lanjut</span></div>
          <p style="font-size:10px; color:rgba(20,33,61,.6); padding:2px 0 8px;">Memantau rekomendasi hingga dijalankan unit kerja.</p>
          <div class="row"><span class="role">05 · Verifikasi Tuntas</span></div>
          <p style="font-size:10px; color:rgba(20,33,61,.6); padding:2px 0;">Status selesai setelah bukti perbaikan diperiksa ulang.</p>
        </div>
        <span class="page-idx">16</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g6" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#5b3a1a"/><stop offset="1" stop-color="#06182E"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g6)"/>
            <path d="M0 220 L70 260 L140 210 L210 250 L300 190 L300 400 L0 400 Z" fill="#1c2f52" opacity="0.75"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">17</span>
      </div>
    </div>

    {{-- SPREAD — 18 Capaian Kinerja | 19 Layanan Kami --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker" style="color:var(--verified);">Capaian</span>
        <h2 style="font-size:16px; margin:8px 0 14px;">Kinerja Pengawasan</h2>
        <div class="bars">
          <div class="bar-row"><span class="bar-label">LHP / Tahun</span><span class="bar-val mono" style="width:auto;">128</span></div>
          <div class="bar-row"><span class="bar-label">Tindak Lanjut</span><span class="bar-val mono" style="width:auto;">96%</span></div>
          <div class="bar-row"><span class="bar-label">Auditor Bersertifikat</span><span class="bar-val mono" style="width:auto;">42</span></div>
          <div class="bar-row"><span class="bar-label">Respons Pengaduan</span><span class="bar-val mono" style="width:auto;">24 jam</span></div>
        </div>
        <span class="page-idx">18</span>
      </div>
      <div class="leaf right-page">
        <span class="kicker">Layanan Kami</span>
        <div class="toc-list" style="margin-left:0; justify-content:flex-start; gap:2px;">
          <div class="toc-row"><span class="no mono">01</span><span class="t">Audit Kinerja &amp; Keuangan</span></div>
          <div class="toc-row"><span class="no mono">02</span><span class="t">Reviu Laporan &amp; Rencana</span></div>
          <div class="toc-row"><span class="no mono">03</span><span class="t">Evaluasi Program</span></div>
          <div class="toc-row"><span class="no mono">04</span><span class="t">Pemantauan Tindak Lanjut</span></div>
          <div class="toc-row"><span class="no mono">05</span><span class="t">Konsultansi &amp; Asistensi</span></div>
          <div class="toc-row"><span class="no mono">06</span><span class="t">Pengaduan Masyarakat</span></div>
        </div>
        <span class="page-idx">19</span>
      </div>
    </div>

    {{-- SPREAD — 20 Kanal Pengaduan | 21 Foto --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker">Ruang Publik</span>
        <h2 style="font-size:16px; margin:8px 0 12px;">Kanal Pengaduan</h2>
        <p>Laporan dugaan penyimpangan ditindaklanjuti secara rahasia — identitas pelapor kami lindungi penuh. Sampaikan lewat salah satu kanal berikut:</p>
        <div class="toc-list" style="margin-left:0; justify-content:flex-start; margin-top:12px;">
          <div class="toc-row"><span class="no mono">•</span><span class="t">Whistleblowing System (WBS)</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">SP4N-LAPOR!</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">Formulir Pengaduan di Website</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">Datang Langsung ke Kantor</span></div>
        </div>
        <span class="page-idx">20</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g7" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2b4470"/><stop offset="1" stop-color="#06182E"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g7)"/>
            <path d="M60 260h100v-60l40 40v20l-40 40v-40H60z" fill="none" stroke="#F3EFE4" stroke-opacity="0.3" stroke-width="3"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">21</span>
      </div>
    </div>

    {{-- SPREAD — 22 Referensi & Ketentuan | 23 Agenda Mendatang --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <h3 class="mono">Referensi &amp; Ketentuan</h3>
        <div class="hint">*Contoh format — sesuaikan dengan regulasi yang berlaku di instansi Anda</div>
        <div class="toc-list" style="margin-left:0; justify-content:flex-start; margin-top:6px;">
          <div class="toc-row"><span class="no mono">•</span><span class="t">[Peraturan tentang Sistem Pengendalian Intern]</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">[Peraturan tentang Pedoman APIP]</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">[Peraturan Daerah terkait Pengawasan]</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">[Kode Etik Auditor Internal]</span></div>
        </div>
        <span class="page-idx">22</span>
      </div>
      <div class="leaf right-page">
        <h3 class="mono">Agenda Mendatang</h3>
        <div class="hint">*Agenda indikatif, sesuaikan dengan jadwal riil</div>
        <div class="toc-list" style="margin-left:0; justify-content:flex-start; margin-top:6px;">
          <div class="toc-row"><span class="no mono">•</span><span class="t">Reviu RKA triwulan berikutnya</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">Sosialisasi WBS ke unit kerja</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">Pelatihan penguatan kapasitas auditor</span></div>
          <div class="toc-row"><span class="no mono">•</span><span class="t">Evaluasi tindak lanjut semester berjalan</span></div>
        </div>
        <span class="page-idx">23</span>
      </div>
    </div>

    {{-- SPREAD — 24 Foto | 25 Kutipan Wawancara --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g8" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#06182E"/><stop offset="1" stop-color="#3a5a8f"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g8)"/>
            <g fill="#B8901F" opacity="0.85">
              <circle cx="70" cy="300" r="8"/><circle cx="140" cy="260" r="8"/><circle cx="210" cy="310" r="8"/><circle cx="250" cy="230" r="8"/>
            </g>
            <polyline points="70,300 140,260 210,310 250,230" fill="none" stroke="#F3EFE4" stroke-opacity="0.35" stroke-width="2"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">24</span>
      </div>
      <div class="leaf right-page">
        <div class="big-quote">
          <div class="qmark">&ldquo;</div>
          <blockquote style="font-size:16px;">{{ $current['iv_a'] }}</blockquote>
          <div class="src mono">{{ $current['iv_who'] }}</div>
        </div>
        <span class="page-idx">25</span>
      </div>
    </div>

    {{-- SPREAD — 26 FAQ Singkat | 27 Foto --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <span class="kicker">Tanya Jawab</span>
        <h2 style="font-size:16px; margin:8px 0 12px;">Seputar Pengaduan</h2>
        <div style="margin-bottom:12px;"><b style="font-size:11px; color:#0B2A4A;">Apakah identitas pelapor dirahasiakan?</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:3px;">Ya, identitas pelapor dilindungi penuh sepanjang proses.</p></div>
        <div style="margin-bottom:12px;"><b style="font-size:11px; color:#0B2A4A;">Berapa lama laporan ditindaklanjuti?</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:3px;">Rata-rata respons awal dalam 24 jam kerja.</p></div>
        <div><b style="font-size:11px; color:#0B2A4A;">Apakah bisa lapor tanpa identitas?</b><p style="font-size:10.5px; color:rgba(20,33,61,.65); margin-top:3px;">Bisa, lewat kanal WBS yang mendukung laporan anonim.</p></div>
        <span class="page-idx">26</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:100%;">
          <svg viewBox="0 0 300 400" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g9" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#3a5a8f"/><stop offset="1" stop-color="#5b3a1a"/></linearGradient></defs>
            <rect width="300" height="400" fill="url(#g9)"/>
            <circle cx="150" cy="160" r="60" fill="none" stroke="#F3EFE4" stroke-opacity="0.3" stroke-width="2"/>
            <path d="M150 100v-20M150 240v-20M90 160h-20M270 160h-20" stroke="#B8901F" stroke-width="4" stroke-linecap="round"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <span class="page-idx">27</span>
      </div>
    </div>

    {{-- SPREAD — 28 Susunan Redaksi | 29 Penutup --}}
    <div class="view" data-pages="2" style="display:none;">
      <div class="leaf left-page">
        <div class="masthead">
          <h3 class="mono">Susunan Redaksi</h3>
          <div class="hint">*Ganti nama di bawah sesuai susunan redaksi tim Anda</div>
          <div class="row"><span class="role">Pembina</span><span class="name">[Nama Pembina]</span></div>
          <div class="row"><span class="role">Penanggung Jawab</span><span class="name">[Nama]</span></div>
          <div class="row"><span class="role">Pemimpin Redaksi</span><span class="name">[Nama]</span></div>
          <div class="row"><span class="role">Redaktur Pelaksana</span><span class="name">[Nama]</span></div>
          <div class="row"><span class="role">Reporter</span><span class="name">[Nama]</span></div>
          <div class="row"><span class="role">Desain &amp; Tata Letak</span><span class="name">[Nama]</span></div>
          <div class="row"><span class="role">Dokumentasi</span><span class="name">[Nama]</span></div>
          <div class="foot mono">Inspektorat Kota Mojokerto · {{ $current['label'] }}</div>
        </div>
        <span class="page-idx">28</span>
      </div>
      <div class="leaf right-page dark">
        <div class="closing-page">
          <h2>Terima Kasih Sudah Membaca</h2>
          <p>Jelajahi edisi lain dari Buletin Pengawasan Inspektorat Kota Mojokerto, atau sampaikan masukan lewat kanal pengaduan resmi kami.</p>
          <a href="{{ route('buletin.index') }}" class="btn">Lihat Edisi Lain</a>
          <svg class="qr" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
            <rect width="60" height="60" fill="none" stroke="#F3EFE4" stroke-width="1.5"/>
            <rect x="6" y="6" width="14" height="14" fill="#F3EFE4"/>
            <rect x="40" y="6" width="14" height="14" fill="#F3EFE4"/>
            <rect x="6" y="40" width="14" height="14" fill="#F3EFE4"/>
            <rect x="26" y="26" width="8" height="8" fill="#F3EFE4"/>
          </svg>
        </div>
        <span class="page-idx">29</span>
      </div>
    </div>

    {{-- HALAMAN 30 — Sampul Belakang (tunggal) --}}
    <div class="view single" data-pages="1" style="display:none;">
      <div class="leaf dark">
        <div class="cov">
          <img class="logo-img" src="{{ asset('images/logo-inspektorat.png') }}" alt="Logo Inspektorat Kota Mojokerto" style="width:110px;">
          <div class="eyebrow" style="margin-top:18px;">Inspektorat Kota Mojokerto</div>
          <div class="rule"></div>
          <div class="edisi">Portal Resmi Pengawasan Intern</div>
        </div>
        <span class="page-idx" style="left:50%; transform:translateX(-50%);">30</span>
      </div>
    </div>

  </div>
  </div>

  <button class="stage-nav right" id="nextBtn" aria-label="Berikutnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
  </button>
</div>

<div class="ctrl-bar">
  <button class="ctrl-btn" id="ctrlPrev" aria-label="Sebelumnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
  </button>
  <span class="ctrl-page mono" id="pageLabel">Hal 1 / {{ $totalPages }}</span>
  <button class="ctrl-btn" id="ctrlNext" aria-label="Berikutnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
  </button>
  <div class="ctrl-sep"></div>
  <button class="ctrl-btn" id="zoomOut" aria-label="Perkecil">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="21" y2="21"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
  </button>
  <button class="ctrl-btn" id="zoomIn" aria-label="Perbesar">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="21" y2="21"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
  </button>
  <div class="ctrl-sep"></div>
  <button class="ctrl-btn" id="fsBtn" aria-label="Layar penuh">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 3H5a2 2 0 00-2 2v3m18 0V5a2 2 0 00-2-2h-3m0 18h3a2 2 0 002-2v-3M3 16v3a2 2 0 002 2h3"/></svg>
  </button>
</div>

{{-- ===== WIDGET AKSESIBILITAS ===== --}}
<button class="a11y-btn" id="a11yBtn" aria-label="Menu Aksesibilitas">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="4.2" r="1.7" fill="currentColor" stroke="none"/>
    <path d="M5 8.2h14M12 8.2v6.2M8 22l1.6-7.6M16 22l-1.6-7.6M7.2 12.4L12 13.4l4.8-1"/>
  </svg>
</button>

<div class="a11y-panel" id="a11yPanel">
  <div class="a11y-head">
    <span>Menu Aksesibilitas (CTRL+U)</span>
    <button id="a11yClose" aria-label="Tutup">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
  </div>
  <div class="a11y-body">
    <div class="a11y-grid">
      <div class="a11y-item" data-a11y="contrast">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 000 18z" fill="currentColor" stroke="none"/></svg>
        Kontras +
      </div>
      <div class="a11y-item" data-a11y="links">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 14a5 5 0 007 0l3-3a5 5 0 00-7-7l-1 1"/><path d="M14 10a5 5 0 00-7 0l-3 3a5 5 0 007 7l1-1"/></svg>
        Sorot Tautan
      </div>
      <div class="a11y-item" data-a11y="bigtext">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7V5h9v2M8.5 5v14M11.5 19h-6M15 13l3-6 3 6M15.8 11h4.4"/></svg>
        Teks Lebih Besar
      </div>
      <div class="a11y-item" data-a11y="spacing">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 12h4M17 12h4M9 8l-2 4 2 4M15 8l2 4-2 4"/></svg>
        Spasi Teks
      </div>
      <div class="a11y-item" data-a11y="noanim">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="6" y="4" width="3" height="16" rx="1"/><rect x="15" y="4" width="3" height="16" rx="1"/></svg>
        Animasi Dijeda
      </div>
      <div class="a11y-item" data-a11y="noimages">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="10" r="1.6" fill="currentColor" stroke="none"/><path d="M3 16l5-5 4 4 3-3 6 6"/><line x1="4" y1="20" x2="20" y2="4"/></svg>
        Sembunyikan Gambar
      </div>
    </div>
    <button class="a11y-reset" id="a11yReset">Reset Semua</button>
  </div>
</div>

<script>
  const views = Array.from(document.querySelectorAll('.view'));
  const totalViews = views.length;
  function pagesOf(v){ return parseInt(v.dataset.pages || '2', 10); }
  const totalPages = views.reduce((sum, v) => sum + pagesOf(v), 0);
  let current = 0;
  let zoom = 1;
  let animating = false;

  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const ctrlPrev = document.getElementById('ctrlPrev');
  const ctrlNext = document.getElementById('ctrlNext');
  const pageLabel = document.getElementById('pageLabel');
  const zoomWrap = document.getElementById('zoomWrap');
  const stage = document.getElementById('stage');

  function startPageFor(index){
    let p = 1;
    for (let i = 0; i < index; i++) p += pagesOf(views[i]);
    return p;
  }

  function render(){
    views.forEach((v, i) => v.style.display = i === current ? 'flex' : 'none');
    const start = startPageFor(current);
    const count = pagesOf(views[current]);
    pageLabel.textContent = count === 1
      ? ('Hal ' + start + ' / ' + totalPages)
      : ('Hal ' + start + '-' + (start + count - 1) + ' / ' + totalPages);
    prevBtn.disabled = ctrlPrev.disabled = current === 0;
    nextBtn.disabled = ctrlNext.disabled = current === totalViews - 1;
  }

  function flipSourceLeaf(view, dir){
    if (view.classList.contains('single')) return view.querySelector('.leaf');
    return dir === 'next' ? view.querySelector('.right-page') : view.querySelector('.left-page');
  }

  function go(i){
    const target = Math.max(0, Math.min(totalViews - 1, i));
    if (target === current || animating) return;
    animating = true;

    const dir = target > current ? 'next' : 'prev';
    const activeView = views[current];
    const leaf = flipSourceLeaf(activeView, dir);

    const leafRect = leaf.getBoundingClientRect();
    const stageRect = stage.getBoundingClientRect();

    const flipEl = document.createElement('div');
    flipEl.className = 'flip-page';
    flipEl.style.left = (leafRect.left - stageRect.left) + 'px';
    flipEl.style.top = (leafRect.top - stageRect.top) + 'px';
    flipEl.style.width = leafRect.width + 'px';
    flipEl.style.height = leafRect.height + 'px';
    flipEl.style.transformOrigin = dir === 'next' ? 'left center' : 'right center';
    flipEl.style.borderRadius = leaf.classList.contains('right-page')
      ? '0 3px 3px 0'
      : leaf.classList.contains('left-page')
        ? '3px 0 0 3px'
        : '6px';
    stage.appendChild(flipEl);

    const reduceMotion = window.__a11yReduceMotion === true;

    requestAnimationFrame(() => {
      flipEl.style.transition = reduceMotion
        ? 'none'
        : 'transform .46s cubic-bezier(.5,0,.35,1), opacity .46s ease .2s';
      flipEl.style.transform = 'rotateY(' + (dir === 'next' ? '-98deg' : '98deg') + ')';
      flipEl.style.opacity = '0';
    });

    setTimeout(() => {
      current = target;
      render();
    }, reduceMotion ? 0 : 230);

    setTimeout(() => {
      flipEl.remove();
      animating = false;
    }, reduceMotion ? 20 : 470);
  }

  prevBtn.addEventListener('click', () => go(current - 1));
  nextBtn.addEventListener('click', () => go(current + 1));
  ctrlPrev.addEventListener('click', () => go(current - 1));
  ctrlNext.addEventListener('click', () => go(current + 1));
  document.addEventListener('keydown', e => {
    if (e.key === 'ArrowLeft') go(current - 1);
    if (e.key === 'ArrowRight') go(current + 1);
  });

  document.getElementById('zoomIn').addEventListener('click', () => {
    zoom = Math.min(1.4, zoom + 0.1);
    zoomWrap.style.transform = 'scale(' + zoom + ')';
  });
  document.getElementById('zoomOut').addEventListener('click', () => {
    zoom = Math.max(0.7, zoom - 0.1);
    zoomWrap.style.transform = 'scale(' + zoom + ')';
  });
  document.getElementById('fsBtn').addEventListener('click', () => {
    if (!document.fullscreenElement) stage.requestFullscreen?.();
    else document.exitFullscreen?.();
  });

  render();
</script>

<script>
  (function(){
    const btn = document.getElementById('a11yBtn');
    const panel = document.getElementById('a11yPanel');
    const closeBtn = document.getElementById('a11yClose');
    const resetBtn = document.getElementById('a11yReset');
    const items = document.querySelectorAll('.a11y-item');
    const root = document.documentElement;

    function togglePanel(){ panel.classList.toggle('open'); }

    btn.addEventListener('click', togglePanel);
    closeBtn.addEventListener('click', () => panel.classList.remove('open'));

    document.addEventListener('keydown', function(e){
      if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
        e.preventDefault();
        togglePanel();
      }
    });

    items.forEach(function(item){
      item.addEventListener('click', function(){
        const key = item.dataset.a11y;
        root.classList.toggle('a11y-' + key);
        item.classList.toggle('active');

        if (key === 'noanim') {
          window.__a11yReduceMotion = root.classList.contains('a11y-noanim');
        }
      });
    });

    resetBtn.addEventListener('click', function(){
      items.forEach(function(item){
        root.classList.remove('a11y-' + item.dataset.a11y);
        item.classList.remove('active');
      });
      window.__a11yReduceMotion = false;
    });
  })();
</script>

</body>
</html>