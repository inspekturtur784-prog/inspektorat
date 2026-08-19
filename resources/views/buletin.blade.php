
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
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{
    background:#0F1B30;
    color:var(--ink);
    font-family:'IBM Plex Sans', sans-serif;
    line-height:1.55;
    -webkit-font-smoothing:antialiased;
    min-height:100vh;
    display:flex; flex-direction:column;
  }
  @media (prefers-reduced-motion: reduce){ *{animation:none !important; transition:none !important;} }
  a{color:inherit; text-decoration:none;}
  .mono{font-family:'IBM Plex Mono', monospace;}
  h1,h2,h3{font-family:'Fraunces', serif; letter-spacing:-.01em;}

  /* ===== TOPBAR ===== */
  .reader-topbar{
    background:var(--ink); color:var(--parchment);
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 28px; flex-wrap:wrap; gap:12px;
    border-bottom:1px solid rgba(243,239,228,.12);
  }
  .back-link{
    display:flex; align-items:center; gap:8px; font-size:13.5px; font-weight:500;
    color:rgba(243,239,228,.8);
  }
  .back-link:hover{color:#fff;}
  .back-link svg{width:16px; height:16px;}
  .topbar-title{
    font-family:'Fraunces', serif; font-size:16px; font-weight:600;
    text-align:center; flex:1; min-width:180px;
  }
  .topbar-title span{
    display:block; font-family:'IBM Plex Mono', monospace; font-size:10.5px;
    letter-spacing:.1em; color:var(--brass-dim); text-transform:uppercase; margin-top:3px; font-weight:400;
  }
  .dl-btn{
    background:var(--rust); color:#fff; font-size:13px; font-weight:600;
    padding:9px 16px; border-radius:3px; display:flex; align-items:center; gap:8px;
    border:1px solid var(--rust);
  }
  .dl-btn:hover{background:#8c3122;}
  .dl-btn svg{width:14px; height:14px;}

  /* ===== STAGE ===== */
  .reader-stage{
    flex:1; display:flex; align-items:center; justify-content:center;
    padding:36px 16px; position:relative;
    background:
      radial-gradient(ellipse at 50% 0%, rgba(184,144,31,.08), transparent 55%),
      #0F1B30;
  }
  .book{
    position:relative; width:100%; max-width:620px; aspect-ratio:3/4;
    box-shadow:0 30px 60px -20px rgba(0,0,0,.6);
  }
  .page{
    position:absolute; inset:0; background:var(--paper);
    padding:44px 40px; overflow:hidden;
    opacity:0; transform:translateX(24px) rotateY(-4deg); pointer-events:none;
    transition:opacity .38s ease, transform .38s ease;
    display:flex; flex-direction:column;
  }
  .page.active{opacity:1; transform:translateX(0) rotateY(0); pointer-events:auto; z-index:2;}
  .page::after{
    content:""; position:absolute; left:0; top:0; bottom:0; width:14px;
    background:linear-gradient(90deg, rgba(20,33,61,.14), transparent);
  }
  .page-num{
    position:absolute; bottom:18px; right:24px; font-family:'IBM Plex Mono',monospace;
    font-size:11px; color:var(--ink-40);
  }

  /* --- cover page --- */
  .cover{ text-align:center; display:flex; flex-direction:column; justify-content:center; align-items:center; height:100%; }
  .cover .logo{
    width:100px; height:100px; border:3px solid var(--brass); border-radius:50%;
    margin:0 auto 26px; display:flex; align-items:center; justify-content:center;
    color:var(--brass); font-weight:700; font-family:'Fraunces',serif; font-size:15px;
  }
  .cover .eyebrow{
    font-family:'IBM Plex Mono',monospace; font-size:11.5px; letter-spacing:.16em;
    color:var(--verified); text-transform:uppercase; margin-bottom:14px;
  }
  .cover h1{ font-size:34px; font-weight:700; color:var(--ink); line-height:1.15; }
  .cover .sub{ margin-top:14px; font-size:14.5px; color:var(--ink-70); max-width:340px; }
  .cover .edisi{
    margin-top:34px; font-family:'IBM Plex Mono',monospace; font-size:12px;
    letter-spacing:.08em; color:var(--brass); border-top:1px solid var(--line);
    border-bottom:1px solid var(--line); padding:10px 22px;
  }

  /* --- daftar isi --- */
  .toc h2{ font-size:22px; margin-bottom:4px; }
  .toc .eyebrow{ font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:.14em; color:var(--verified); text-transform:uppercase; margin-bottom:10px; display:block;}
  .toc-list{ margin-top:22px; display:flex; flex-direction:column; gap:0; }
  .toc-item{
    display:flex; justify-content:space-between; align-items:baseline; gap:10px;
    padding:13px 0; border-bottom:1px dotted var(--line); font-size:14px;
  }
  .toc-item .t{font-weight:600;}
  .toc-item .p{font-family:'IBM Plex Mono',monospace; color:var(--ink-40); font-size:12px;}

  /* --- artikel --- */
  .article .kicker{ font-family:'IBM Plex Mono',monospace; font-size:10.5px; letter-spacing:.14em; color:var(--rust); text-transform:uppercase; }
  .article h2{ font-size:23px; margin:10px 0 14px; line-height:1.2; }
  .article p{ font-size:13.5px; color:var(--ink-70); margin-bottom:12px; text-align:justify; }
  .article .pull{
    border-left:3px solid var(--brass); padding:4px 0 4px 16px; margin:16px 0;
    font-family:'Fraunces',serif; font-style:italic; font-size:15px; color:var(--ink);
  }

  /* --- infografis --- */
  .infografis h2{ font-size:21px; margin-bottom:4px; }
  .bars{ margin-top:26px; display:flex; flex-direction:column; gap:16px; }
  .bar-row{ display:flex; align-items:center; gap:12px; }
  .bar-label{ width:120px; font-size:12px; color:var(--ink-70); flex-shrink:0; }
  .bar-track{ flex:1; height:10px; background:var(--parchment-2); border-radius:2px; overflow:hidden; }
  .bar-fill{ height:100%; background:var(--brass); border-radius:2px; }
  .bar-val{ width:42px; text-align:right; font-family:'IBM Plex Mono',monospace; font-size:12px; color:var(--ink); flex-shrink:0; }

  /* --- wawancara / penutup --- */
  .interview .q{ font-weight:600; font-size:13.5px; margin:14px 0 4px; }
  .interview .a{ font-size:13.5px; color:var(--ink-70); margin-bottom:6px; }
  .interview .who{ margin-top:22px; font-family:'IBM Plex Mono',monospace; font-size:11.5px; color:var(--verified); border-top:1px solid var(--line); padding-top:12px; }

  /* ===== CONTROLS ===== */
  .nav-btn{
    position:absolute; top:50%; transform:translateY(-50%);
    width:42px; height:42px; border-radius:50%; background:rgba(243,239,228,.1);
    border:1px solid rgba(243,239,228,.25); color:var(--parchment);
    display:flex; align-items:center; justify-content:center; cursor:pointer;
    transition:background .2s ease;
  }
  .nav-btn:hover{background:rgba(243,239,228,.22);}
  .nav-btn:disabled{opacity:.3; cursor:default;}
  .nav-btn svg{width:18px; height:18px;}
  .nav-prev{left:6px;} .nav-next{right:6px;}
  @media(min-width:720px){ .nav-prev{left:-58px;} .nav-next{right:-58px;} }

  /* ===== FOOTER BAR ===== */
  .reader-footbar{
    background:var(--ink); padding:16px 28px; display:flex; align-items:center;
    justify-content:center; gap:18px; flex-wrap:wrap;
  }
  .progress-wrap{ width:220px; }
  .progress-track{ height:4px; background:rgba(243,239,228,.18); border-radius:2px; overflow:hidden; }
  .progress-fill{ height:100%; background:var(--brass); width:20%; transition:width .3s ease; }
  .progress-meta{
    display:flex; justify-content:space-between; margin-top:6px;
    font-family:'IBM Plex Mono',monospace; font-size:10.5px; color:rgba(243,239,228,.6);
  }
  .thumb-dots{ display:flex; gap:6px; }
  .thumb-dot{
    width:7px; height:7px; border-radius:50%; background:rgba(243,239,228,.25);
    cursor:pointer; transition:background .2s ease;
  }
  .thumb-dot.active{ background:var(--brass); }

  @media (max-width:560px){
    .page{ padding:30px 24px; }
    .cover h1{ font-size:26px; }
    .topbar-title{ order:3; width:100%; }
  }
</style>
</head>
<body>

<div class="reader-topbar">
  <a href="{{ url('/publikasi') }}" class="back-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
    Kembali ke Publikasi
  </a>
  <div class="topbar-title">
    Buletin Pengawasan
    <span>Edisi 01 · Triwulan I 2026</span>
  </div>
  <a href="#" class="dl-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12m0 0l-4-4m4 4l4-4M4 21h16"/></svg>
    Unduh PDF
  </a>
</div>

<div class="reader-stage">
  <button class="nav-btn nav-prev" id="prevBtn" aria-label="Halaman sebelumnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
  </button>

  <div class="book" id="book">

    {{-- HALAMAN 1 — COVER --}}
    <section class="page active">
      <div class="cover">
        <div class="logo">INSP</div>
        <div class="eyebrow">Terverifikasi &middot; Pengawasan Intern</div>
        <h1>Buletin<br>Pengawasan</h1>
        <p class="sub">Transparan prosesnya, akuntabel hasilnya — kabar dan catatan dari ruang kerja pengawasan.</p>
        <div class="edisi">EDISI 01 &middot; TRIWULAN I 2026</div>
      </div>
      <span class="page-num mono">1 / 5</span>
    </section>

    {{-- HALAMAN 2 — DAFTAR ISI --}}
    <section class="page">
      <div class="toc">
        <span class="eyebrow">Daftar Isi</span>
        <h2>Dalam Edisi Ini</h2>
        <div class="toc-list">
          <div class="toc-item"><span class="t">Dari Redaksi</span><span class="p mono">03</span></div>
          <div class="toc-item"><span class="t">Laporan Utama — Reviu Sebelum Realisasi</span><span class="p mono">04</span></div>
          <div class="toc-item"><span class="t">Sorotan — Capaian Tindak Lanjut Triwulan I</span><span class="p mono">06</span></div>
          <div class="toc-item"><span class="t">Wawancara — Menjaga Independensi Auditor</span><span class="p mono">08</span></div>
          <div class="toc-item"><span class="t">Ruang Publik — Cara Mengajukan Pengaduan</span><span class="p mono">10</span></div>
        </div>
      </div>
      <span class="page-num mono">2 / 5</span>
    </section>

    {{-- HALAMAN 3 — LAPORAN UTAMA --}}
    <section class="page">
      <div class="article">
        <span class="kicker">Laporan Utama</span>
        <h2>Reviu Sebelum Realisasi: Mencegah Lebih Murah daripada Mengoreksi</h2>
        <p>Sebagian besar temuan pemeriksaan sebenarnya bisa dicegah sejak dokumen perencanaan disusun. Karena itu, Inspektorat mendorong setiap unit kerja mengajukan reviu sebelum anggaran direalisasikan, bukan menunggu audit di akhir tahun anggaran.</p>
        <p class="pull">"Koreksi yang dilakukan di atas kertas jauh lebih murah dibanding koreksi yang harus dilakukan setelah anggaran terlanjur cair."</p>
        <p>Sepanjang triwulan pertama, tercatat puluhan dokumen rencana kerja telah melalui proses reviu, dengan sebagian besar catatan berupa penyesuaian kecil pada rincian anggaran dan target keluaran — jauh lebih ringan ditangani dibanding temuan pasca-realisasi.</p>
      </div>
      <span class="page-num mono">3 / 5</span>
    </section>

    {{-- HALAMAN 4 — INFOGRAFIS --}}
    <section class="page">
      <div class="infografis">
        <span class="kicker" style="font-family:'IBM Plex Mono',monospace; font-size:10.5px; letter-spacing:.14em; color:var(--verified); text-transform:uppercase;">Sorotan</span>
        <h2>Capaian Tindak Lanjut Triwulan I</h2>
        <div class="bars">
          <div class="bar-row"><span class="bar-label">Selesai Tuntas</span><div class="bar-track"><div class="bar-fill" style="width:78%"></div></div><span class="bar-val mono">78%</span></div>
          <div class="bar-row"><span class="bar-label">Proses Verifikasi</span><div class="bar-track"><div class="bar-fill" style="width:14%"></div></div><span class="bar-val mono">14%</span></div>
          <div class="bar-row"><span class="bar-label">Belum Ditindaklanjuti</span><div class="bar-track"><div class="bar-fill" style="width:8%; background:var(--rust);"></div></div><span class="bar-val mono">8%</span></div>
        </div>
        <p style="margin-top:26px; font-size:13px; color:var(--ink-70);">Dari 96 rekomendasi hasil pemeriksaan triwulan sebelumnya, mayoritas telah dinyatakan tuntas usai verifikasi lapangan. Sisanya masih dikawal tim pemantauan hingga bukti perbaikan lengkap diterima.</p>
      </div>
      <span class="page-num mono">4 / 5</span>
    </section>

    {{-- HALAMAN 5 — WAWANCARA & PENUTUP --}}
    <section class="page">
      <div class="interview">
        <span class="kicker">Wawancara</span>
        <h2 style="font-size:20px; margin:10px 0 16px;">Menjaga Independensi di Tengah Tekanan</h2>
        <p class="q">Apa tantangan terbesar menjaga independensi pemeriksaan?</p>
        <p class="a">Tantangannya bukan soal aturan, tapi soal keberanian menjaga jarak — termasuk dari pihak yang justru paling dekat dengan kita sehari-hari di kantor.</p>
        <p class="q">Bagaimana memastikan hasil pemeriksaan tetap dipercaya publik?</p>
        <p class="a">Dengan konsisten: metodenya sama untuk semua objek pemeriksaan, dan setiap simpulan selalu bisa ditelusuri kembali ke buktinya.</p>
        <div class="who">— Narasumber, Tim Pemeriksa Inspektorat</div>
      </div>
      <span class="page-num mono">5 / 5</span>
    </section>

  </div>

  <button class="nav-btn nav-next" id="nextBtn" aria-label="Halaman berikutnya">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
  </button>
</div>

<div class="reader-footbar">
  <div class="thumb-dots" id="dots"></div>
  <div class="progress-wrap">
    <div class="progress-track"><div class="progress-fill" id="progressFill"></div></div>
    <div class="progress-meta">
      <span id="progressPct">20%</span>
      <span id="progressCount">1 / 5</span>
    </div>
  </div>
</div>

<script>
  const pages = document.querySelectorAll('.page');
  const total = pages.length;
  let current = 0;

  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const progressFill = document.getElementById('progressFill');
  const progressPct = document.getElementById('progressPct');
  const progressCount = document.getElementById('progressCount');
  const dotsWrap = document.getElementById('dots');

  pages.forEach((_, i) => {
    const dot = document.createElement('div');
    dot.className = 'thumb-dot' + (i === 0 ? ' active' : '');
    dot.addEventListener('click', () => goTo(i));
    dotsWrap.appendChild(dot);
  });
  const dots = document.querySelectorAll('.thumb-dot');

  function render(){
    pages.forEach((p, i) => p.classList.toggle('active', i === current));
    dots.forEach((d, i) => d.classList.toggle('active', i === current));
    const pct = Math.round(((current + 1) / total) * 100);
    progressFill.style.width = pct + '%';
    progressPct.textContent = pct + '%';
    progressCount.textContent = (current + 1) + ' / ' + total;
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current === total - 1;
  }

  function goTo(i){
    current = Math.max(0, Math.min(total - 1, i));
    render();
  }

  prevBtn.addEventListener('click', () => goTo(current - 1));
  nextBtn.addEventListener('click', () => goTo(current + 1));
  document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') goTo(current - 1);
    if (e.key === 'ArrowRight') goTo(current + 1);
  });

  render();
</script>

</body>
</html>