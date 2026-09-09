<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $buletin->title }} — Buletin Pengawasan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;0,9..144,700;0,9..144,900;1,9..144,500;1,9..144,600&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<style>
  :root{
    --navy:#0B2A4A; --navy-deep:#06182E; --navy-soft:#12335A;
    --ink:#F3EFE4; --ink-70:rgba(243,239,228,.72); --ink-40:rgba(243,239,228,.42);
    --brass:#B8901F; --brass-dim:#EFE3C4; --rust:#A63D2C;
    --line: rgba(20,33,61,.14);
    --stage: var(--navy-deep);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{background:var(--stage); color:var(--ink); font-family:'IBM Plex Sans',sans-serif; line-height:1.5; overflow-x:hidden;}
  a{color:inherit; text-decoration:none;}
  .mono{font-family:'IBM Plex Mono',monospace;}
  h1,h2,h3{font-family:'Fraunces',serif; letter-spacing:-.01em;}
  button{font-family:inherit;}

  .breadcrumb{
    background:var(--navy-deep); padding:8px 26px;
    font-family:'IBM Plex Mono',monospace; font-size:11px;
    color:rgba(243,239,228,.5); display:flex; align-items:center; gap:6px;
  }
  .breadcrumb a:hover{ color:var(--ink); }
  .breadcrumb .sep{ color:rgba(243,239,228,.25); }
  .breadcrumb .current{ color:var(--brass); }

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
    background:#fff;
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

  .view{
    display:flex; box-shadow:0 40px 90px -30px rgba(0,0,0,.75);
    max-width:920px; width:100%;
  }
  .view.single{ max-width:460px; margin:0 auto; }
  .view.single .leaf{ width:100%; border-radius:6px; aspect-ratio:3/4; }
  .view.single .leaf::after{ display:none; }

  .leaf{
    background:#fff; width:50%; aspect-ratio:3/4;
    position:relative; overflow:hidden;
    display:flex; align-items:center; justify-content:center;
  }
  .leaf img{ width:100%; height:100%; object-fit:contain; background:#fff; display:block; }
  .leaf.left-page{border-radius:3px 0 0 3px;}
  .leaf.right-page{border-radius:0 3px 3px 0; border-left:1px solid rgba(20,33,61,.08);}
  .leaf.left-page::after{content:""; position:absolute; right:0; top:0; bottom:0; width:24px; background:linear-gradient(90deg, transparent, rgba(20,33,61,.08));}
  .leaf.right-page::after{content:""; position:absolute; left:0; top:0; bottom:0; width:24px; background:linear-gradient(270deg, transparent, rgba(20,33,61,.08));}
  .page-idx{position:absolute; bottom:10px; font-family:'IBM Plex Mono',monospace; font-size:10px; color:rgba(20,33,61,.45); background:rgba(255,255,255,.75); padding:1px 6px; border-radius:8px;}
  .leaf.left-page .page-idx{left:14px;}
  .leaf.right-page .page-idx{right:14px;}
  .view.single .page-idx{ left:50%; transform:translateX(-50%); }

  .loading-screen{
    color:var(--ink); text-align:center; font-family:'IBM Plex Mono',monospace;
    font-size:13px; letter-spacing:.04em;
  }
  .loading-screen .bar{
    width:220px; height:4px; background:rgba(255,255,255,.15); border-radius:4px;
    overflow:hidden; margin:16px auto 0;
  }
  .loading-screen .bar-fill{
    height:100%; width:0%; background:var(--brass); transition:width .2s ease;
  }

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

  html.a11y-contrast body{ filter:contrast(1.35) brightness(1.05); }
  html.a11y-links a{ outline:2px solid var(--a11y-blue) !important; background:#fff59d !important; color:#14213D !important; }
  html.a11y-bigtext{ font-size:118%; }
  html.a11y-spacing body{ letter-spacing:.03em; line-height:1.9; }
  html.a11y-noanim *{ animation-duration:.001s !important; animation-delay:0s !important; transition-duration:.001s !important; }
  html.a11y-noimages .leaf img{ visibility:hidden !important; }

  @media (max-width:860px){
    .stage{ padding:30px 16px 110px; }
    .stage-nav{ width:36px; height:36px; }
    .stage-nav.left{ left:6px; } .stage-nav.right{ right:6px; }
    .view{ max-width:100%; }
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
  <span class="current">{{ $buletin->title }}</span>
</div>

<div class="reader-topbar">
  <a href="{{ route('buletin.index') }}" class="back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    Kembali ke Publikasi
  </a>
  <div class="topbar-title">
    {{ $buletin->title }}
    <span>{{ $buletin->label }}</span>
  </div>
  @if($buletin->pdf_url)
    <a href="{{ $buletin->pdf_url }}" class="dl-btn" download>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16"/></svg>
      Unduh PDF
    </a>
  @endif
</div>

<div class="stage" id="stage">
  <button class="stage-nav left" id="prevBtn" aria-label="Sebelumnya" style="display:none;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
  </button>

  <div id="loadingScreen" class="loading-screen">
    <div>Memuat buletin&hellip;</div>
    <div class="bar"><div class="bar-fill" id="loadBarFill"></div></div>
  </div>

  <div id="zoomWrap" style="display:none;">
    <div id="spreadWrap"></div>
  </div>

  <button class="stage-nav right" id="nextBtn" aria-label="Berikutnya" style="display:none;">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
  </button>
</div>

<div class="ctrl-bar" id="ctrlBar" style="display:none;">
  <button class="ctrl-btn" id="ctrlPrev" aria-label="Sebelumnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
  </button>
  <span class="ctrl-page mono" id="pageLabel">Hal 1</span>
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
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

  const PDF_URL = @json($buletin->pdf_url);
  const spreadWrap = document.getElementById('spreadWrap');
  const zoomWrap = document.getElementById('zoomWrap');
  const loadingScreen = document.getElementById('loadingScreen');
  const loadBarFill = document.getElementById('loadBarFill');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const ctrlBar = document.getElementById('ctrlBar');
  const ctrlPrev = document.getElementById('ctrlPrev');
  const ctrlNext = document.getElementById('ctrlNext');
  const pageLabel = document.getElementById('pageLabel');
  const stage = document.getElementById('stage');

  let views = [];
  let totalViews = 0;
  let totalPages = 0;
  let current = 0;
  let zoom = 1;
  let animating = false;

  function pagesOf(v){ return parseInt(v.dataset.pages || '1', 10); }

  function buildPagePairs(n){
    const pairs = [];
    if (n <= 0) return pairs;
    pairs.push([1]);
    let i = 2;
    while (i <= n) {
      if (i === n) { pairs.push([i]); i++; }
      else { pairs.push([i, i + 1]); i += 2; }
    }
    return pairs;
  }

  async function renderAllPages(pdf) {
    const n = pdf.numPages;
    const images = [];
    for (let p = 1; p <= n; p++) {
      const page = await pdf.getPage(p);
      const viewport = page.getViewport({ scale: 1.6 });
      const canvas = document.createElement('canvas');
      canvas.width = viewport.width;
      canvas.height = viewport.height;
      const ctx = canvas.getContext('2d');
      await page.render({ canvasContext: ctx, viewport }).promise;
      images.push(canvas.toDataURL('image/jpeg', 0.85));
      loadBarFill.style.width = Math.round((p / n) * 100) + '%';
    }
    return images;
  }

  function buildViewsDOM(images) {
    const pairs = buildPagePairs(images.length);
    pairs.forEach(pair => {
      const viewEl = document.createElement('div');
      if (pair.length === 1) {
        viewEl.className = 'view single';
        viewEl.dataset.pages = '1';
        viewEl.innerHTML = `
          <div class="leaf">
            <img src="${images[pair[0]-1]}" alt="Halaman ${pair[0]}">
            <span class="page-idx">${pair[0]}</span>
          </div>`;
      } else {
        viewEl.className = 'view';
        viewEl.dataset.pages = '2';
        viewEl.innerHTML = `
          <div class="leaf left-page">
            <img src="${images[pair[0]-1]}" alt="Halaman ${pair[0]}">
            <span class="page-idx">${pair[0]}</span>
          </div>
          <div class="leaf right-page">
            <img src="${images[pair[1]-1]}" alt="Halaman ${pair[1]}">
            <span class="page-idx">${pair[1]}</span>
          </div>`;
      }
      spreadWrap.appendChild(viewEl);
    });
    views = Array.from(document.querySelectorAll('.view'));
    totalViews = views.length;
    totalPages = images.length;
  }

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

  async function init() {
    if (!PDF_URL) {
      loadingScreen.textContent = 'File PDF belum tersedia untuk buletin ini.';
      return;
    }
    try {
      const pdf = await pdfjsLib.getDocument(PDF_URL).promise;
      const images = await renderAllPages(pdf);
      buildViewsDOM(images);
      loadingScreen.style.display = 'none';
      zoomWrap.style.display = 'block';
      prevBtn.style.display = 'flex';
      nextBtn.style.display = 'flex';
      ctrlBar.style.display = 'flex';
      render();
    } catch (err) {
      console.error(err);
      loadingScreen.textContent = 'Gagal memuat file PDF. Coba muat ulang halaman.';
    }
  }

  init();
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