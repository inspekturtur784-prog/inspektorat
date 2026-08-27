{{--
  resources/views/buletin/show.blade.php
  Reader "buku terbuka" per edisi. Data edisi ($current, $totalPages)
  dikirim dari routes/web.php, BUKAN didefinisikan di file ini —
  supaya file ini aman di-copy-paste tanpa risiko bagian atas kepotong.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $current['title'] }} — Buletin Pengawasan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,900&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
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

  /* konten halaman ("kertas") tetap terang & gelap teks, walau panggung gelap */
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

  /* ===== STAGE (panggung gelap) ===== */
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

  .spread{
    display:flex; box-shadow:0 40px 90px -30px rgba(0,0,0,.75);
    max-width:920px; width:100%;
  }
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

  .leaf.dark{ background:var(--navy); color:var(--ink); }
  .leaf.dark .page-idx{ color:rgba(243,239,228,.4); }

  .cov{ text-align:center; display:flex; flex-direction:column; justify-content:center; align-items:center; height:100%; }
  .cov .logo{ width:78px; height:78px; border:2.5px solid var(--brass); border-radius:50%; margin-bottom:20px; display:flex; align-items:center; justify-content:center; color:var(--brass); font-family:'Fraunces',serif; font-weight:700; font-size:13px;}
  .cov .eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:10px; letter-spacing:.16em; color:var(--brass); text-transform:uppercase; margin-bottom:12px;}
  .cov h1{ font-size:24px; font-weight:700; color:var(--ink); line-height:1.16;}
  .cov .edisi{ margin-top:22px; font-family:'IBM Plex Mono',monospace; font-size:10.5px; letter-spacing:.08em; color:rgba(243,239,228,.65); border-top:1px solid rgba(243,239,228,.2); padding-top:10px;}

  .photo-panel{ position:relative; width:100%; height:100%; overflow:hidden; }
  .photo-panel svg{ position:absolute; inset:0; width:100%; height:100%; }
  .photo-cap{ position:absolute; left:18px; bottom:18px; right:18px; font-family:'IBM Plex Mono',monospace; font-size:9.5px; letter-spacing:.06em; color:rgba(255,255,255,.75); text-transform:uppercase; }

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

  @media (max-width:860px){
    .stage{ padding:30px 16px 110px; }
    .stage-nav{ width:36px; height:36px; }
    .stage-nav.left{ left:6px; } .stage-nav.right{ right:6px; }
    .spread{ max-width:100%; }
    .leaf{ padding:22px 18px; }
    .cov h1{ font-size:18px; }
    .toc .vert{ font-size:17px; left:14px; }
    .toc-list{ margin-left:34px; }
    .art h2{ font-size:14px; }
  }
  @media (max-width:640px){
    .spread{ flex-direction:column; }
    .leaf{ width:100%; aspect-ratio:auto; min-height:64vh; }
    .leaf.left-page::after, .leaf.right-page::after{ display:none; }
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

    {{-- SPREAD 1 — Cover + Dari Redaksi --}}
    <div class="spread" data-spread="0">
      <div class="leaf left-page dark">
        <div class="cov">
          <div class="logo">INSP</div>
          <div class="eyebrow">Terverifikasi</div>
          <h1>{{ $current['title'] }}</h1>
          <div class="edisi">{{ $current['label'] }}</div>
        </div>
        <span class="page-idx">01</span>
      </div>
      <div class="leaf right-page">
        <div class="photo-panel" style="height:58%;">
          <svg viewBox="0 0 300 260" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <defs><linearGradient id="g1" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#23375c"/><stop offset="1" stop-color="#0B2A4A"/></linearGradient></defs>
            <rect width="300" height="260" fill="url(#g1)"/>
            <g opacity="0.85">
              <rect x="30" y="150" width="26" height="90" fill="#1c2f52"/>
              <rect x="62" y="120" width="26" height="120" fill="#233a63"/>
              <rect x="94" y="165" width="26" height="75" fill="#1c2f52"/>
              <rect x="126" y="90" width="26" height="150" fill="#2b4470"/>
              <rect x="158" y="135" width="26" height="105" fill="#1c2f52"/>
            </g>
            <circle cx="245" cy="55" r="26" fill="#B8901F" opacity="0.85"/>
          </svg>
          <span class="photo-cap">Ilustrasi</span>
        </div>
        <div class="kicker" style="margin-top:16px;">Dari Redaksi</div>
        <p style="font-size:11.5px; color:rgba(20,33,61,.7); margin-top:8px; text-align:justify;">{{ $current['intro'] }}</p>
        <span class="page-idx">02</span>
      </div>
    </div>

    {{-- SPREAD 2 — Daftar Isi + Foto --}}
    <div class="spread" data-spread="1" style="display:none;">
      <div class="leaf left-page toc">
        <div class="vert">CONTENTS</div>
        <div class="toc-list">
          @foreach ($current['toc'] as $row)
            <div class="toc-row"><span class="no mono">{{ $row['no'] }}</span><span class="t">{{ $row['t'] }}</span></div>
          @endforeach
        </div>
        <span class="page-idx">03</span>
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
        <span class="page-idx">04</span>
      </div>
    </div>

    {{-- SPREAD 3 — Artikel Utama + Foto --}}
    <div class="spread" data-spread="2" style="display:none;">
      <div class="leaf left-page art">
        <span class="kicker">{{ $current['art_kicker'] }}</span>
        <h2>{{ $current['art_title'] }}</h2>
        <p>{{ $current['art_p1'] }}</p>
        <p class="pull">{{ $current['art_pull'] }}</p>
        <p>{{ $current['art_p2'] }}</p>
        <span class="page-idx">05</span>
      </div>
      <div class="leaf right-page">
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
    </div>

    {{-- SPREAD 4 — Infografis + Wawancara --}}
    <div class="spread" data-spread="3" style="display:none;">
      <div class="leaf left-page">
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
      <div class="leaf right-page">
        <span class="kicker">Wawancara</span>
        <h2 style="font-size:16px; margin:8px 0 12px;">{{ $current['iv_title'] }}</h2>
        <p style="font-size:11.5px; font-weight:600; margin-bottom:4px; color:#0B2A4A;">{{ $current['iv_q'] }}</p>
        <p style="font-size:11.5px; color:rgba(20,33,61,.7); margin-bottom:10px;">{{ $current['iv_a'] }}</p>
        <div class="who">— {{ $current['iv_who'] }}</div>
        <span class="page-idx">08</span>
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
  <span class="ctrl-page mono" id="pageLabel">Hal 1-2 / {{ $totalPages }}</span>
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

<script>
  const spreads = document.querySelectorAll('.spread');
  const totalSpreads = spreads.length;
  const totalPages = totalSpreads * 2;
  let current = 0;
  let zoom = 1;

  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const ctrlPrev = document.getElementById('ctrlPrev');
  const ctrlNext = document.getElementById('ctrlNext');
  const pageLabel = document.getElementById('pageLabel');
  const spreadWrap = document.getElementById('spreadWrap');
  const zoomWrap = document.getElementById('zoomWrap');
  const stage = document.getElementById('stage');

  function render(){
    spreads.forEach((s,i) => s.style.display = i === current ? 'flex' : 'none');
    const startPage = current * 2 + 1;
    pageLabel.textContent = 'Hal ' + startPage + '-' + (startPage+1) + ' / ' + totalPages;
    prevBtn.disabled = ctrlPrev.disabled = current === 0;
    nextBtn.disabled = ctrlNext.disabled = current === totalSpreads - 1;
  }

  let animating = false;
  function go(i){
    const target = Math.max(0, Math.min(totalSpreads-1, i));
    if (target === current || animating) return;
    animating = true;

    const dir = target > current ? 'next' : 'prev';
    const activeSpread = spreads[current];
    const leaf = dir === 'next'
      ? activeSpread.querySelector('.right-page')
      : activeSpread.querySelector('.left-page');

    const leafRect = leaf.getBoundingClientRect();
    const stageRect = stage.getBoundingClientRect();

    const flipEl = document.createElement('div');
    flipEl.className = 'flip-page';
    flipEl.style.left = (leafRect.left - stageRect.left) + 'px';
    flipEl.style.top = (leafRect.top - stageRect.top) + 'px';
    flipEl.style.width = leafRect.width + 'px';
    flipEl.style.height = leafRect.height + 'px';
    flipEl.style.transformOrigin = dir === 'next' ? 'left center' : 'right center';
    flipEl.style.borderRadius = dir === 'next' ? '0 3px 3px 0' : '3px 0 0 3px';
    stage.appendChild(flipEl);

    requestAnimationFrame(() => {
      flipEl.style.transition = 'transform .46s cubic-bezier(.5,0,.35,1), opacity .46s ease .2s';
      flipEl.style.transform = 'rotateY(' + (dir === 'next' ? '-98deg' : '98deg') + ')';
      flipEl.style.opacity = '0';
    });

    setTimeout(() => {
      current = target;
      render();
    }, 230);

    setTimeout(() => {
      flipEl.remove();
      animating = false;
    }, 470);
  }

  prevBtn.addEventListener('click', () => go(current-1));
  nextBtn.addEventListener('click', () => go(current+1));
  ctrlPrev.addEventListener('click', () => go(current-1));
  ctrlNext.addEventListener('click', () => go(current+1));
  document.addEventListener('keydown', e => {
    if (e.key === 'ArrowLeft') go(current-1);
    if (e.key === 'ArrowRight') go(current+1);
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

</body>
</html>