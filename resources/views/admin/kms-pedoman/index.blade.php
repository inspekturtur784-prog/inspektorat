@extends('admin.layout')
@section('title', 'KMS & Pedoman')

@section('content')
<style>
    .kp-subtitle-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .kp-divider { border:none; border-top:1px solid #e5e2da; margin:36px 0; }

    .kp-upload-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media (max-width: 900px) { .kp-upload-grid { grid-template-columns:1fr; } }
    .kp-upload-card { background:#fff; border-radius:14px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.06); border-top:4px solid var(--navy, #1e2a4a); }
    .kp-upload-card h3 { margin:0 0 4px; font-size:16px; }
    .kp-upload-card p.kp-desc { margin:0 0 16px; font-size:13px; color:#888; }
    .kp-field { margin-bottom:14px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input, .kp-field select, .kp-field textarea { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    .kp-upload-card .btn-admin-primary { width:100%; padding:11px; font-size:14px; margin-top:4px; text-align:center; }
    .kp-manage { display:none; }
    .kp-manage.open { display:block; }
    .kp-note { font-size:13px; color:#888; margin-top:10px; }
</style>

<div class="admin-header"><h1>KMS &amp; Pedoman</h1></div>

<div class="kp-subtitle-row">
    <strong>Upload Dokumen</strong>
    <button type="button" class="btn-admin btn-admin-ghost" onclick="document.getElementById('kp-manage-area').classList.toggle('open'); this.textContent = document.getElementById('kp-manage-area').classList.contains('open') ? '\u25b2 Sembunyikan Kelola Kategori' : '+ Kelola Kategori & Subkategori';">
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
            <button type="submit" class="btn-admin btn-admin-primary">Upload Dokumen KMS</button>
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
            <button type="submit" class="btn-admin btn-admin-primary">Upload Dokumen Pedoman</button>
        </form>
        @if ($pedomanKategoris->isEmpty())
            <p class="kp-desc" style="margin-top:10px;">Belum ada kategori Pedoman. Klik "+ Kelola Kategori & Subkategori" di atas untuk buat yang pertama.</p>
        @endif
    </div>
</div>

<div id="kp-manage-area" class="kp-manage">
    <hr class="kp-divider">

    <div class="admin-header">
        <h1 class="admin-header-sub">Knowledge Base (KMS)</h1>
        <a href="{{ route('admin.kms.kategori.create') }}" class="btn-admin btn-admin-primary">+ Tambah Kategori KMS</a>
    </div>
    <p class="admin-subtitle">{{ $kmsKategoris->count() }} kategori &middot; {{ $kmsDokumens->count() }} dokumen</p>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Nama Kategori</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($kmsKategoris as $kategori)
                <tr>
                    <td>{{ $kategori->nama }}</td>
                    <td class="row-actions">
                        <a href="{{ route('admin.kms.kategori.show', $kategori) }}" class="btn-admin btn-admin-ghost">Kelola</a>
                        <a href="{{ route('admin.kms.kategori.edit', $kategori) }}" class="btn-admin btn-admin-ghost">Edit</a>
                        <form action="{{ route('admin.kms.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta semua isinya?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="2">Belum ada kategori KMS.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <p class="kp-note">Klik "Kelola" pada kategori untuk masuk ke subkategori &amp; dokumen di dalamnya.</p>

    <hr class="kp-divider">

    <div class="admin-header">
        <h1 class="admin-header-sub">Pedoman</h1>
        <a href="{{ route('admin.pedoman.kategori.create') }}" class="btn-admin btn-admin-primary">+ Tambah Kategori Pedoman</a>
    </div>
    <p class="admin-subtitle">{{ $pedomanKategoris->count() }} kategori &middot; {{ $pedomanDokumens->count() }} dokumen</p>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Nama Kategori</th><th>Jumlah Dokumen</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse ($pedomanKategoris as $kategori)
                <tr>
                    <td>{{ $kategori->nama }}</td>
                    <td>{{ $pedomanDokumens->where('pedoman_kategori_id', $kategori->id)->count() }}</td>
                    <td class="row-actions">
                        <a href="{{ route('admin.pedoman.kategori.show', $kategori) }}" class="btn-admin btn-admin-ghost">Kelola</a>
                        <a href="{{ route('admin.pedoman.kategori.edit', $kategori) }}" class="btn-admin btn-admin-ghost">Edit</a>
                        <form action="{{ route('admin.pedoman.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori pedoman ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Belum ada kategori Pedoman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <p class="kp-note">Klik "Kelola" pada kategori untuk melihat dokumen di dalamnya.</p>
</div>
@endsection