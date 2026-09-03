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
  }
  a{color:inherit; text-decoration:none;}
  .mono{font-family:'IBM Plex Mono', monospace;}
  h1,h2,h3{font-family:'Fraunces', serif; letter-spacing:-.01em;}

  .topbar{
    background:var(--navy); color:var(--parchment);
    padding:22px 28px; text-align:center;
    border-bottom:1px solid rgba(243,239,228,.12);
  }
  .topbar .eyebrow{
    font-family:'IBM Plex Mono',monospace; font-size:11px; letter-spacing:.16em;
    color:var(--verified); text-transform:uppercase; margin-bottom:8px;
  }
  .topbar h1{ font-size:26px; font-weight:700; }
  .breadcrumb{
    font-family:'IBM Plex Mono',monospace; font-size:11.5px;
    color:rgba(243,239,228,.55); margin-bottom:14px;
    display:flex; align-items:center; gap:6px; justify-content:center;
  }
  .breadcrumb a:hover{ color:var(--parchment); }
  .breadcrumb .sep{ color:rgba(243,239,228,.3); }
  .breadcrumb .current{ color:var(--brass); }

  .wrap{ max-width:1000px; margin:0 auto; padding:40px 24px 80px; }

  .grid{
    display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));
    gap:22px;
  }

  .card{
    background:var(--paper); color:var(--ink); border-radius:6px; overflow:hidden;
    display:flex; flex-direction:column; box-shadow:0 12px 30px -12px rgba(0,0,0,.5);
    transition:transform .18s ease, box-shadow .18s ease;
  }
  .card:hover{ transform:translateY(-3px); box-shadow:0 18px 40px -14px rgba(0,0,0,.6); }

  .card-cover{
    background:linear-gradient(135deg, var(--navy) 0%, var(--navy-deep) 100%);
    padding:26px 22px; position:relative;
  }
  .card-cover .label{
    font-family:'IBM Plex Mono',monospace; font-size:10.5px; letter-spacing:.1em;
    color:var(--brass); text-transform:uppercase; margin-bottom:10px;
  }
  .card-cover h2{
    font-size:19px; font-weight:700; color:var(--parchment); line-height:1.25;
  }

  .card-body{ padding:20px 22px 22px; display:flex; flex-direction:column; flex:1; }
  .card-body p{
    font-size:12.5px; color:var(--ink-70); flex:1; margin-bottom:16px;
    display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
  }
  .card-body .read-link{
    font-family:'IBM Plex Mono',monospace; font-size:11.5px; font-weight:600;
    color:var(--rust); display:inline-flex; align-items:center; gap:6px;
  }
  .card-body .read-link svg{ width:13px; height:13px; }

  @media (max-width:560px){
    .topbar h1{ font-size:21px; }
    .wrap{ padding:28px 16px 60px; }
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
  <div class="eyebrow">Terverifikasi &middot; Pengawasan Intern</div>
  <h1>Buletin Pengawasan</h1>
</div>

<div class="wrap">
  <div class="grid">
    @foreach ($editions as $slug => $edition)
      <a href="{{ route('buletin.show', $slug) }}" class="card">
        <div class="card-cover">
          <div class="label mono">{{ $edition['label'] }}</div>
          <h2>{{ $edition['title'] }}</h2>
        </div>
        <div class="card-body">
          <p>{{ $edition['intro'] }}</p>
          <span class="read-link">
            Baca Edisi
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
          </span>
        </div>
      </a>
    @endforeach
  </div>
</div>

</body>
</html>