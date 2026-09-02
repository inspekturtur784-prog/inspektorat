<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pengaduan Masyarakat — Inspektorat</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,900&family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root{
    --navy:#0B2A4A; --navy-deep:#06182E; --navy-soft:#12335A; --navy-soft-2:#0D2440;
    --ink:#F3EFE4; --ink-70:rgba(243,239,228,.72); --ink-40:rgba(243,239,228,.42);
    --parchment:var(--navy-deep); --parchment-2:var(--navy-soft-2); --paper:var(--navy-soft);
    --verified:#4CAE81; --brass:#D6A93A; --rust:#C24E38; --line: rgba(243,239,228,.14);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{background:var(--parchment); color:var(--ink); font-family:'IBM Plex Sans',sans-serif; line-height:1.5;}
  a{color:inherit; text-decoration:none;}
  .mono{font-family:'IBM Plex Mono',monospace;}
  h1,h2{font-family:'Fraunces',serif; letter-spacing:-.01em;}
  .wrap{max-width:720px; margin:0 auto; padding:0 24px;}

  header{background:var(--navy-deep); padding:20px 0; border-bottom:1px solid var(--line);}
  .back-link{display:flex; align-items:center; gap:8px; font-size:13.5px; color:rgba(243,239,228,.8); font-weight:500;}
  .back-link:hover{color:#fff;}
  .back-link svg{width:16px; height:16px;}

  .hero-strip{padding:52px 0 30px;}
  .eyebrow{font-family:'IBM Plex Mono',monospace; font-size:12px; letter-spacing:.14em; text-transform:uppercase; color:var(--verified); display:flex; align-items:center; gap:10px; margin-bottom:14px;}
  .eyebrow::before{content:""; width:16px; height:1px; background:var(--verified);}
  .hero-strip h1{font-size:clamp(26px,3.4vw,36px); font-weight:600;}
  .hero-strip p{margin-top:12px; color:var(--ink-70); font-size:14.5px; max-width:520px;}

  .notice{
    display:flex; gap:12px; background:var(--parchment-2); border:1px solid var(--line);
    padding:16px 18px; border-radius:2px; margin:24px 0 8px; font-size:13px; color:var(--ink-70);
  }
  .notice svg{width:18px; height:18px; flex-shrink:0; color:var(--verified); margin-top:1px;}

  main{padding:20px 0 90px;}
  form{display:flex; flex-direction:column; gap:20px;}
  .field label{display:block; font-size:13px; font-weight:600; margin-bottom:8px;}
  .field .hint{font-weight:400; color:var(--ink-40); font-size:12px; margin-left:6px;}
  .field input, .field select, .field textarea{
    width:100%; border:1px solid var(--line); background:var(--paper); padding:12px 14px;
    font-family:'IBM Plex Sans',sans-serif; font-size:14px; color:var(--ink); border-radius:2px;
  }
  .field input:focus, .field select:focus, .field textarea:focus{
    outline:none; border-color:var(--verified);
  }
  .field textarea{resize:vertical; min-height:130px;}
  .row-2{display:grid; grid-template-columns:1fr 1fr; gap:20px;}

  .radio-group{display:flex; gap:10px; flex-wrap:wrap;}
  .radio-opt{
    border:1px solid var(--line); padding:10px 16px; border-radius:2px; font-size:13px;
    cursor:pointer; background:var(--paper);
  }
  .radio-opt input{width:auto; margin-right:8px;}

  .submit-btn{
    background:var(--rust); color:#fff; font-size:14.5px; font-weight:600;
    padding:14px 24px; border-radius:3px; border:none; cursor:pointer; align-self:flex-start;
  }
  .submit-btn:hover{background:#8c3122;}

  .alt-channel{
    margin-top:40px; padding-top:28px; border-top:1px solid var(--line);
    font-size:13px; color:var(--ink-70);
  }
  .alt-channel a{color:var(--verified); font-weight:600;}

  @media (max-width:600px){ .row-2{grid-template-columns:1fr;} }
</style>
</head>
<body>

<header>
  <div class="wrap">
    <a href="{{ url('/') }}" class="back-link">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
      Kembali ke Beranda
    </a>
  </div>
</header>

<section class="hero-strip">
  <div class="wrap">
    <div class="eyebrow">Layanan Pengaduan</div>
    <h1>Sampaikan Dugaan Penyimpangan</h1>
    <p>Laporan Anda akan ditindaklanjuti oleh tim pengawasan. Identitas pelapor dijaga kerahasiaannya sesuai ketentuan yang berlaku.</p>

    <div class="notice">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
      <span>Data pribadi dan isi laporan yang Anda kirim hanya dapat diakses oleh tim pengawasan internal yang berwenang menangani pengaduan.</span>
    </div>
  </div>
</section>

<main class="wrap">
  {{-- action & method sesuaikan dengan controller kamu, contoh: --}}
  {{-- <form action="{{ route('pengaduan.store') }}" method="POST"> --}}
  <form action="#" method="POST">
    @csrf

    <div class="field">
      <label>Jenis Pelapor</label>
      <div class="radio-group">
        <label class="radio-opt"><input type="radio" name="jenis_pelapor" value="masyarakat" checked> Masyarakat Umum</label>
        <label class="radio-opt"><input type="radio" name="jenis_pelapor" value="asn"> ASN / Pegawai</label>
        <label class="radio-opt"><input type="radio" name="jenis_pelapor" value="anonim"> Anonim</label>
      </div>
    </div>

    <div class="row-2">
      <div class="field">
        <label>Nama Lengkap <span class="hint">(opsional bila anonim)</span></label>
        <input type="text" name="nama" placeholder="Nama Anda">
      </div>
      <div class="field">
        <label>Nomor Telepon / Email</label>
        <input type="text" name="kontak" placeholder="08xx atau email@contoh.com">
      </div>
    </div>

    <div class="field">
      <label>Unit / Instansi yang Diadukan</label>
      <input type="text" name="unit_diadukan" placeholder="Contoh: Dinas Pekerjaan Umum" required>
    </div>

    <div class="field">
      <label>Kategori Dugaan Penyimpangan</label>
      <select name="kategori" required>
        <option value="">Pilih kategori</option>
        <option value="anggaran">Penyimpangan Anggaran</option>
        <option value="pelayanan">Pelayanan Publik</option>
        <option value="kepegawaian">Kepegawaian</option>
        <option value="pengadaan">Pengadaan Barang & Jasa</option>
        <option value="lainnya">Lainnya</option>
      </select>
    </div>

    <div class="field">
      <label>Kronologi / Uraian Laporan</label>
      <textarea name="uraian" placeholder="Jelaskan kejadian, waktu, tempat, dan pihak yang terlibat sedetail mungkin..." required></textarea>
    </div>

    <div class="field">
      <label>Lampiran Bukti <span class="hint">(foto, dokumen — opsional)</span></label>
      <input type="file" name="lampiran">
    </div>

    <button type="submit" class="submit-btn">Kirim Laporan</button>
  </form>

  <div class="alt-channel">
    Butuh jalur lain? Anda juga bisa melapor lewat
    <a href="https://wbs.bpkp.go.id/" target="_blank">Whistleblowing System</a> atau
    <a href="https://www.lapor.go.id/" target="_blank">SP4N LAPOR!</a>.
  </div>
</main>

</body>
</html>