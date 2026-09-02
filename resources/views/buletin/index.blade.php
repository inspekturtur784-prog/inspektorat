<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buletin Pengawasan — Inspektorat</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,900&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --ink:#14213D;
    --ink-70:rgba(20,33,61,.68);
    --ink-40:rgba(20,33,61,.4);
    --parchment:#F3EFE4;
    --parchment-2:#EAE3D2;
    --paper:#FBF9F3;
    --verified:#2F6F4E;
    --brass:#B8901F;
    --brass-dim:#EFE3C4;
    --rust:#A63D2C;
    --line: rgba(20,33,61,.14);
    --navy:#0B2A4A;
    --navy-soft:#12335A;
    --navy-deep:#06182E;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{
    background:var(--navy-deep);
    color:var(--parchment);
    font-family:'IBM Plex Sans', sans-serif;
    line-height:1.55;
    -webkit-font-smoothing:antialiased;
    min-height:100vh;
    transition:background .3s ease;
  }
  a{color:inherit; text-decoration:none;}
  .mono{font-family:'IBM Plex Mono', monospace;}
  h1,h2,h3{font-family:'Fraunces', serif; letter-spacing:-.01em;}

  .topbar{
    background:var(--navy); color:var(--parchment);
    padding:22px 28px; text-align:center;
    border-bottom:1px solid rgba(243,239,228,.12);
    transition:background .3s ease, color .3s ease, border-color .3s ease;
  }
  .breadcrumb{
    font-family:'IBM Plex Mono',monospace; font-size:11.5px;
    color:rgba(243,239,228,.55); margin-bottom:0;
    display:flex; align-items:center; gap:6px; justify-content:center;
    transition:color .3s ease;
  }
  .breadcrumb a:hover{ color:var(--parchment); }
  .breadcrumb .sep{ color:rgba(243,239,228,.3); }
  .breadcrumb .current{ color:var(--brass); }

  /* ===== HERO / JUDUL HALAMAN ===== */
  .page-hero{
    background:radial-gradient(ellipse at 50% 0%, var(--navy-soft) 0%, var(--navy-deep) 68%);
    padding:46px 24px 30px; text-align:center;
    border-bottom:1px solid rgba(243,239,228,.08);
    transition:background .3s ease, border-color .3s ease;
  }
  .page-hero .eyebrow{
    font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:.16em;
    color:var(--verified); text-transform:uppercase; margin-bottom:12px;
  }
  .page-hero h1{
    font-size:38px; font-weight:900; color:var(--parchment); line-height:1.08;
    transition:color .3s ease;
  }
  .page-hero p{
    margin-top:10px; font-size:13.5px; color:rgba(243,239,228,.6);
    max-width:480px; margin-left:auto; margin-right:auto;
    transition:color .3s ease;
  }

  /* ===== FILTER BAR (search + tahun) ===== */
  .filter-bar{
    max-width:1080px; margin:0 auto; padding:30px 24px 4px;
    position:relative; z-index:1;
  }
  .search-box{
    position:relative; display:flex; align-items:center;
    background:linear-gradient(135deg, #FFFFFF 0%, #E9E9EC 100%);
    border-radius:999px; padding:4px;
    box-shadow:0 18px 40px -16px rgba(0,0,0,.55);
  }
  .search-box svg{
    width:19px; height:19px; color:var(--ink-40); flex-shrink:0; margin-left:18px;
  }
  .search-box input{
    flex:1; border:none; background:transparent; outline:none;
    font-family:'IBM Plex Sans',sans-serif; font-size:15px; color:var(--ink);
    padding:15px 18px;
  }
  .search-box input::placeholder{ color:var(--ink-40); }

  .year-filters{
    display:flex; flex-wrap:wrap; gap:10px; justify-content:center;
    margin-top:20px;
  }
  .year-chip{
    font-family:'IBM Plex Mono',monospace; font-size:12.5px; font-weight:600;
    padding:10px 20px; border-radius:999px; cursor:pointer; border:none;
    background:var(--navy); color:var(--parchment);
    transition:background .15s ease, color .15s ease, transform .1s ease;
    white-space:nowrap;
  }
  .year-chip:hover{ background:#12335A; }
  .year-chip.active{
    background:#fff; color:var(--ink);
  }
  .no-results{
    display:none; text-align:center; padding:60px 20px;
    color:rgba(243,239,228,.55); font-family:'IBM Plex Mono',monospace; font-size:13px;
    transition:color .3s ease;
  }
  .no-results.show{ display:block; }

  .wrap{
    max-width:1080px; margin:0 auto; padding:36px 24px 90px;
    background:radial-gradient(ellipse at 50% 0%, var(--navy-soft) 0%, var(--navy-deep) 55%);
    transition:background .3s ease;
  }

  .grid{
    display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr));
    gap:24px;
  }

  /* ===== CARD ===== */
  .card{
    background:var(--paper); color:var(--ink); border-radius:14px; overflow:hidden;
    display:flex; flex-direction:column;
    box-shadow:0 14px 34px -16px rgba(0,0,0,.55);
    border:1px solid rgba(20,33,61,.05);
    transition:transform .2s ease, box-shadow .2s ease, opacity .15s ease;
  }
  .card:hover{ transform:translateY(-5px); box-shadow:0 24px 50px -18px rgba(0,0,0,.65); }
  .card:hover .cover-img{ transform:scale(1.05); }
  .card:hover .read-link svg{ transform:translateX(3px); }
  .card.hidden{ display:none; }

  .card-cover{
    position:relative; aspect-ratio:16/11; overflow:hidden;
    background:linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%);
  }
  .card-cover .cover-img{
    position:absolute; inset:0; width:100%; height:100%; object-fit:cover;
    transition:transform .35s ease;
  }
  .card-cover .cover-fallback{
    position:absolute; inset:0; padding:22px; display:flex; flex-direction:column; justify-content:flex-end;
  }
  .card-cover .cover-fallback svg{ position:absolute; inset:0; width:100%; height:100%; opacity:.5; }
  .card-cover .badge{
    position:relative; z-index:1;
    font-family:'IBM Plex Mono',monospace; font-size:10px; letter-spacing:.1em;
    color:var(--brass-dim); text-transform:uppercase; margin-bottom:4px;
  }
  .card-cover .cover-title{
    position:relative; z-index:1; font-size:16px; font-weight:700; color:var(--parchment); line-height:1.2;
  }

  .card-body{ padding:18px 20px 20px; display:flex; flex-direction:column; flex:1; }
  .card-body h2{
    font-family:'IBM Plex Sans',sans-serif; font-size:16px; font-weight:700;
    color:var(--ink); line-height:1.3; margin-bottom:10px;
  }
  .card-meta{
    display:flex; align-items:center; gap:14px; margin-bottom:14px;
    font-family:'IBM Plex Mono',monospace; font-size:10.5px; color:var(--ink-40);
  }
  .card-meta span{ display:flex; align-items:center; gap:5px; }
  .card-meta svg{ width:12px; height:12px; flex-shrink:0; }

  .card-body .read-link{
    margin-top:auto;
    font-family:'IBM Plex Mono',monospace; font-size:11.5px; font-weight:600;
    color:var(--rust); display:inline-flex; align-items:center; gap:6px;
    border-bottom:1px solid rgba(166,61,44,.35); padding-bottom:2px; width:fit-content;
  }
  .card-body .read-link svg{ width:13px; height:13px; transition:transform .18s ease; }

  /* ===== MODE SIANG / MALAM ===== */
  html.light-mode body{ background:#DCD3BA; }
  html.light-mode .topbar{ background:#FBF9F3; color:#0B2A4A; border-bottom:1px solid rgba(11,42,74,.12); }
  html.light-mode .breadcrumb{ color:rgba(11,42,74,.55); }
  html.light-mode .breadcrumb a:hover{ color:#0B2A4A; }
  html.light-mode .breadcrumb .sep{ color:rgba(11,42,74,.28); }
  html.light-mode .page-hero{ background:radial-gradient(ellipse at 50% 0%, #EFE9D8 0%, #DCD3BA 68%); border-bottom:1px solid rgba(11,42,74,.1); }
  html.light-mode .page-hero h1{ color:#0B2A4A; }
  html.light-mode .page-hero p{ color:rgba(11,42,74,.62); }
  html.light-mode .wrap{ background:radial-gradient(ellipse at 50% 0%, #EFE9D8 0%, #DCD3BA 55%); }
  html.light-mode .no-results{ color:rgba(11,42,74,.55); }
  html.light-mode .year-chip{ background:#fff; color:#0B2A4A; border:1px solid rgba(11,42,74,.14); }
  html.light-mode .year-chip:hover{ background:#F0ECE0; }
  html.light-mode .year-chip.active{ background:#0B2A4A; color:#fff; border-color:#0B2A4A; }

  .theme-btn{
    position:fixed; right:20px; bottom:26px; z-index:60;
    width:48px; height:48px; border-radius:50%;
    background:var(--navy); color:#fff; border:1px solid rgba(255,255,255,.14); cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 10px 24px rgba(0,0,0,.4);
    transition:background .3s ease, color .3s ease, border-color .3s ease;
  }
  .theme-btn svg{ width:22px; height:22px; }
  .theme-btn .icon-sun{ display:none; }
  html.light-mode .theme-btn{ background:#fff; color:#0B2A4A; border-color:rgba(11,42,74,.16); }
  html.light-mode .theme-btn .icon-moon{ display:none; }
  html.light-mode .theme-btn .icon-sun{ display:flex; }

  @media (max-width:560px){
    .page-hero h1{ font-size:27px; }
    .wrap{ padding:28px 16px 60px; }
    .search-box input{ font-size:14px; padding:13px 14px; }
    .year-chip{ padding:8px 16px; font-size:11.5px; }
    .theme-btn{ width:42px; height:42px; right:14px; bottom:14px; }
  }
</style>
</head>
<body>

<div class="topbar">
  <div class="breadcrumb">
    <a href="{{ url('/') }}">Beranda</a>
    <span class="sep">/</span>
    <span class="current">Publikasi</span>
  </div>
</div>

<div class="page-hero">
  <div class="eyebrow">Terverifikasi &middot; Pengawasan Intern</div>
  <h1>Koleksi Buletin</h1>
  <p>Telusuri seluruh koleksi Buletin Pengawasan Inspektorat Kota Mojokerto</p>
</div>

{{-- ===== SEARCH + FILTER TAHUN ===== --}}
<div class="filter-bar">
  <div class="search-box">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Ketik nama majalah atau tahun...">
  </div>
  <div class="year-filters" id="yearFilters">
    <button class="year-chip active" data-year="all">Semua Tahun</button>
    {{-- tombol tahun lain diisi otomatis oleh JS dari data edisi yang ada --}}
  </div>
</div>

<div class="wrap">
  <div class="grid" id="editionGrid">
    @foreach ($editions as $slug => $edition)
      @php
        $year = preg_match('/\d{4}/', $edition['label'], $m) ? $m[0] : (preg_match('/\d{4}/', $edition['title'], $m2) ? $m2[0] : '');
        $wordCount = str_word_count(strip_tags($edition['intro'] ?? ''));
        $readMinutes = max(1, (int) ceil($wordCount / 200));

        // Cari gambar cover otomatis dari folder public/images/buletin/{slug}.(jpg|jpeg|png|webp)
        // Guru cukup upload file dengan nama = slug edisi ini, TANPA perlu edit kode.
        $coverPath = null;
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
          if (file_exists(public_path("images/buletin/{$slug}.{$ext}"))) {
            $coverPath = asset("images/buletin/{$slug}.{$ext}");
            break;
          }
        }
        // Tetap dukung field 'image' manual di data lama, kalau ada
        $coverPath = $coverPath ?: ($edition['image'] ?? null);
      @endphp
      <a href="{{ route('buletin.show', $slug) }}"
         class="card"
         data-title="{{ strtolower($edition['title']) }} {{ strtolower($edition['label']) }}"
         data-year="{{ $year }}">
        <div class="card-cover">
          @if($coverPath)
            <img class="cover-img" src="{{ $coverPath }}" alt="{{ $edition['title'] }}">
          @else
            <svg viewBox="0 0 300 200" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <radialGradient id="cg-{{ $slug }}" cx="50%" cy="20%" r="70%">
                  <stop offset="0%" stop-color="#B8901F" stop-opacity="0.35"/>
                  <stop offset="100%" stop-color="#B8901F" stop-opacity="0"/>
                </radialGradient>
              </defs>
              <rect width="300" height="200" fill="url(#cg-{{ $slug }})"/>
              <g stroke="#F3EFE4" stroke-opacity="0.08" stroke-width="1">
                <line x1="0" y1="60" x2="300" y2="60"/>
                <line x1="0" y1="120" x2="300" y2="120"/>
                <line x1="75" y1="0" x2="75" y2="200"/>
                <line x1="150" y1="0" x2="150" y2="200"/>
                <line x1="225" y1="0" x2="225" y2="200"/>
              </g>
            </svg>
            <div class="cover-fallback">
              <div class="badge mono">{{ $edition['label'] }}</div>
              <div class="cover-title">{{ $edition['title'] }}</div>
            </div>
          @endif
        </div>
        <div class="card-body">
          <h2>{{ $edition['title'] }}</h2>
          <div class="card-meta">
            <span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="16" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="3" x2="8" y2="7"/><line x1="16" y1="3" x2="16" y2="7"/></svg>
              {{ $edition['label'] }}
            </span>
            <span>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
              {{ $readMinutes }} Min Baca
            </span>
          </div>
          <span class="read-link">
            Baca Majalah
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          </span>
        </div>
      </a>
    @endforeach
  </div>
  <div class="no-results" id="noResults">Tidak ada edisi yang cocok dengan pencarian.</div>
</div>

{{-- ===== TOMBOL MODE SIANG / MALAM ===== --}}
<button class="theme-btn" id="themeBtn" aria-label="Ganti Mode Siang/Malam">
  <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
  </svg>
  <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="12" r="4.5"/>
    <path d="M12 2v2.5M12 19.5V22M4.2 4.2l1.8 1.8M18 18l1.8 1.8M2 12h2.5M19.5 12H22M4.2 19.8L6 18M18 6l1.8-1.8"/>
  </svg>
</button>

<script>
(function(){
  const cards = Array.from(document.querySelectorAll('#editionGrid .card'));
  const yearFilters = document.getElementById('yearFilters');
  const searchInput = document.getElementById('searchInput');
  const noResults = document.getElementById('noResults');
  let activeYear = 'all';

  // Bangun daftar tahun otomatis dari tahun yang beneran ada di data edisi (urut terbaru dulu)
  const years = Array.from(new Set(cards.map(c => c.dataset.year).filter(Boolean)))
    .sort((a, b) => b.localeCompare(a));

  years.forEach(year => {
    const btn = document.createElement('button');
    btn.className = 'year-chip';
    btn.dataset.year = year;
    btn.textContent = year;
    yearFilters.appendChild(btn);
  });

  function applyFilters(){
    const query = searchInput.value.trim().toLowerCase();
    let visibleCount = 0;

    cards.forEach(card => {
      const matchesYear = activeYear === 'all' || card.dataset.year === activeYear;
      const matchesQuery = query === '' || card.dataset.title.includes(query);
      const visible = matchesYear && matchesQuery;
      card.classList.toggle('hidden', !visible);
      if (visible) visibleCount++;
    });

    noResults.classList.toggle('show', visibleCount === 0);
  }

  yearFilters.addEventListener('click', function(e){
    const btn = e.target.closest('.year-chip');
    if (!btn) return;
    yearFilters.querySelectorAll('.year-chip').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    activeYear = btn.dataset.year;
    applyFilters();
  });

  searchInput.addEventListener('input', applyFilters);
})();
</script>

{{-- ===== SCRIPT MODE SIANG / MALAM ===== --}}
<script>
  (function(){
    const root = document.documentElement;
    const btn = document.getElementById('themeBtn');
    const STORAGE_KEY = 'buletin-theme';

    function applyTheme(mode){
      if (mode === 'light') {
        root.classList.add('light-mode');
      } else {
        root.classList.remove('light-mode');
      }
    }

    let saved = null;
    try { saved = localStorage.getItem(STORAGE_KEY); } catch (e) {}

    if (saved === 'light' || saved === 'dark') {
      applyTheme(saved);
    } else {
      // belum pernah pilih -> ikuti jam perangkat: 06.00-17.59 = siang
      const hour = new Date().getHours();
      applyTheme(hour >= 6 && hour < 18 ? 'light' : 'dark');
    }

    btn.addEventListener('click', function(){
      const isLight = root.classList.toggle('light-mode');
      try { localStorage.setItem(STORAGE_KEY, isLight ? 'light' : 'dark'); } catch (e) {}
    });
  })();
</script>

</body>
</html>