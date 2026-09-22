@extends('admin.layout')
@section('title', 'KMS & Pedoman')

@section('content')
<style>
    .kp-wrap { font-family:inherit; }
    .kp-section { margin-bottom:40px; }
    .kp-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0; }
    .kp-header h2 { font-size:18px; font-weight:700; color:#1e2a4a; margin:0; }
    .kp-header p.kp-count { font-size:13px; color:#888; margin:2px 0 0; }
    .kp-btn { border:none; cursor:pointer; padding:9px 16px; border-radius:999px; font-size:13px; font-weight:600; text-decoration:none; display:inline-block; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; color:#fff; }
    .kp-btn-outline { background:#eeece6; color:#333; margin-right:6px; }
    .kp-btn-outline:hover { background:#e2ded4; color:#333; }
    .kp-btn-danger { background:#8b1e2b; color:#fff; }
    .kp-btn-danger:hover { background:#a3242f; color:#fff; }
    .kp-card { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06); overflow:hidden; margin-bottom:24px; }
    .kp-table { width:100%; border-collapse:collapse; }
    .kp-table thead th { text-align:left; font-size:11px; letter-spacing:.05em; text-transform:uppercase; color:#8b8b8b; padding:14px 18px; border-bottom:1px solid #eee; }
    .kp-table tbody td { padding:14px 18px; border-bottom:1px solid #f2f2f2; font-size:14px; color:#333; }
    .kp-table tbody tr:last-child td { border-bottom:none; }
    .kp-table tbody tr:hover { background:#fafafa; }
    .kp-empty { text-align:center; color:#999; padding:28px; }
    .kp-divider { border:none; border-top:1px solid #e5e2da; margin:36px 0; }
    .kp-subtitle-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px; }

    .kp-upload-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media (max-width: 900px) { .kp-upload-grid { grid-template-columns:1fr; } }
    .kp-upload-card { background:#fff; border-radius:14px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.06); border-top:4px solid #1e2a4a; }
    .kp-upload-card h3 { margin:0 0 4px; font-size:16px; color:#1e2a4a; }
    .kp-upload-card p.kp-desc { margin:0 0 16px; font-size:13px; color:#888; }
    .kp-field { margin-bottom:14px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input, .kp-field select, .kp-field textarea { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    .kp-upload-card .kp-btn-primary { width:100%; padding:11px; font-size:14px; margin-top:4px; }
    .kp-manage { display:none; }
    .kp-manage.open { display:block; }
</style>

<div class="kp-wrap">
    <div class="kp-header">
        <h1>KMS &amp; Pedoman</h1>
    </div>

    <div class="kp-subtitle-row">
        <p style="font-size:15px;font-weight:700;color:#1e2a4a;margin:0;">Upload Dokumen</p>
        <button type="button" class="kp-btn kp-btn-outline" onclick="document.getElementById('kp-manage-area').classList.toggle('open'); this.textContent = document.getElementById('kp-manage-area').classList.contains('open') ? '\u25b2 Sembunyikan Kelola Kategori' : '+ Kelola Kategori & Subkategori';">
            + Kelola Kategori &amp; Subkategori
        </button>
    </div>

    <div class="kp-upload-grid">
        <div class="kp-upload-card">
            <h3>Knowledge Base (KMS)</h3>
            <p class="kp-desc">Pilih subkategori, isi judul, unggah filenya. Selesai.</p>
            <form action="{{ route('admin.kms.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="grup_dokumen_id" value="">
                <div class="kp-field">
                    <label>Kategori / Subkategori</label>
                    <select name="subkategori_id" required>
                        <option value="">-- Pilih Subkategori --</option>
                        @foreach ($kmsSubkategoris->sortBy(fn($s) => ($s->kategori->nama ?? '') . $s->nama)->groupBy(fn($s) => $s->kategori->nama ?? '-') as $namaKategori => $subs)
                            <optgroup label="{{ $namaKategori }}">
                                @foreach ($subs as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->nama }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="kp-field">
                    <label>Judul Dokumen</label>
                    <input type="text" name="judul" required>
                </div>
                <div class="kp-field">
                    <label>File PDF atau Video (mp4, mov, avi, wmv, mkv &mdash; maks 100MB)</label>
                    <input type="file" name="file" accept="application/pdf,video/*" required>
                </div>
                <button type="submit" class="kp-btn kp-btn-primary">Upload Dokumen KMS</button>
            </form>
            @if ($kmsSubkategoris->isEmpty())
                <p class="kp-desc" style="margin-top:10px;">Belum ada subkategori. Klik "+ Kelola Kategori & Subkategori" di atas untuk buat yang pertama.</p>
            @endif
        </div>

        <div class="kp-upload-card">
            <h3>Pedoman</h3>
            <p class="kp-desc">Pilih kategori, isi judul, unggah filenya. Selesai.</p>
            <form action="{{ route('admin.pedoman.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="kp-field">
                    <label>Kategori</label>
                    <select name="pedoman_kategori_id" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($pedomanKategoris->sortBy('nama') as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="kp-field">
                    <label>Judul Dokumen</label>
                    <input type="text" name="judul" required>
                </div>
                <div class="kp-field">
                    <label>File PDF (maks 20MB)</label>
                    <input type="file" name="file" accept="application/pdf" required>
                </div>
                <button type="submit" class="kp-btn kp-btn-primary">Upload Dokumen Pedoman</button>
            </form>
            @if ($pedomanKategoris->isEmpty())
                <p class="kp-desc" style="margin-top:10px;">Belum ada kategori Pedoman. Klik "+ Kelola Kategori & Subkategori" di atas untuk buat yang pertama.</p>
            @endif
        </div>
    </div>

    <div id="kp-manage-area" class="kp-manage">
        <hr class="kp-divider">

        <div class="kp-section">
            <div class="kp-header">
                <div>
                    <h2>Knowledge Base (KMS)</h2>
                    <p class="kp-count">{{ $kmsKategoris->count() }} kategori &middot; {{ $kmsDokumens->count() }} dokumen</p>
                </div>
                <a href="{{ route('admin.kms.kategori.create') }}" class="kp-btn kp-btn-primary">+ Tambah Kategori KMS</a>
            </div>

            <div class="kp-card">
                <table class="kp-table">
                    <thead><tr><th>Nama Kategori</th><th style="width:220px;">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($kmsKategoris as $kategori)
                        <tr>
                            <td>{{ $kategori->nama }}</td>
                            <td>
                                <a href="{{ route('admin.kms.kategori.show', $kategori) }}" class="kp-btn kp-btn-outline">Kelola</a>
                                <a href="{{ route('admin.kms.kategori.edit', $kategori) }}" class="kp-btn kp-btn-outline">Edit</a>
                                <form action="{{ route('admin.kms.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta semua isinya?');" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="kp-empty">Belum ada kategori KMS.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p style="font-size:13px;color:#888;">Klik "Kelola" pada kategori untuk masuk ke subkategori &amp; dokumen di dalamnya.</p>
        </div>

        <hr class="kp-divider">

        <div class="kp-section">
            <div class="kp-header">
                <div>
                    <h2>Pedoman</h2>
                    <p class="kp-count">{{ $pedomanKategoris->count() }} kategori &middot; {{ $pedomanDokumens->count() }} dokumen</p>
                </div>
                <a href="{{ route('admin.pedoman.kategori.create') }}" class="kp-btn kp-btn-primary">+ Tambah Kategori Pedoman</a>
            </div>

            <div class="kp-card">
                <table class="kp-table">
                    <thead><tr><th>Nama Kategori</th><th>Jumlah Dokumen</th><th style="width:220px;">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($pedomanKategoris as $kategori)
                        <tr>
                            <td>{{ $kategori->nama }}</td>
                            <td>{{ $pedomanDokumens->where('pedoman_kategori_id', $kategori->id)->count() }}</td>
                            <td>
                                <a href="{{ route('admin.pedoman.kategori.show', $kategori) }}" class="kp-btn kp-btn-outline">Kelola</a>
                                <a href="{{ route('admin.pedoman.kategori.edit', $kategori) }}" class="kp-btn kp-btn-outline">Edit</a>
                                <form action="{{ route('admin.pedoman.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori pedoman ini?');" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="kp-empty">Belum ada kategori Pedoman.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p style="font-size:13px;color:#888;">Klik "Kelola" pada kategori untuk melihat dokumen di dalamnya.</p>
        </div>
    </div>
</div>
@endsection