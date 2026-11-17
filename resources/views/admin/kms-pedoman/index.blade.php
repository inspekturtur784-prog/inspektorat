@extends('admin.layout')
@section('title', 'KMS')

@section('content')
<style>
    .kp-panel { display:none; margin-bottom:28px; }
    .kp-panel.open { display:block; }
    .kp-upload-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
    @media (max-width: 900px) { .kp-upload-grid { grid-template-columns:1fr; } }
    .kp-upload-card { background:#fff; border-radius:14px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,.06); border-top:4px solid #1e2a4a; }
    .kp-upload-card h3 { margin:0 0 4px; font-size:16px; color:#1e2a4a; }
    .kp-upload-card p.kp-desc { margin:0 0 16px; font-size:13px; color:#888; }
    .kp-field { margin-bottom:14px; }
    .kp-field label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; }
    .kp-field input, .kp-field select { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; font-family:inherit; }
    .kp-upload-card .kp-btn-primary { width:100%; padding:11px; font-size:14px; margin-top:4px; }
</style>

@php
    $kpDocs = $kmsDokumens->map(fn ($d) => [
        'judul'  => $d->judul,
        'sumber' => 'KMS',
        'lokasi' => ($d->kategori->nama ?? '-') . ' / ' . ($d->subkategori->nama ?? '-'),
        'lihat'  => url('/files/' . $d->file_path),
        'edit'   => route('admin.kms.dokumen.edit', $d),
    ])->concat($pedomanDokumens->map(fn ($d) => [
        'judul'  => $d->judul,
        'sumber' => 'Pedoman',
        'lokasi' => $d->kategori->nama ?? '-',
        'lihat'  => url('/files/' . $d->file_path),
        'edit'   => route('admin.pedoman.dokumen.edit', $d),
    ]))->values();
@endphp

<div class="kp-header">
    <h1>KMS</h1>
    <div class="kp-top-actions">
        <button type="button" class="kp-btn kp-btn-primary" onclick="kpTogglePanel()">+ Tambah Dokumen</button>
        <a href="{{ route('admin.kms.kategori.create') }}" class="kp-btn kp-btn-outline">+ Kategori KMS</a>
        <a href="{{ route('admin.pedoman.kategori.create') }}" class="kp-btn kp-btn-outline">+ Kategori Pedoman</a>
        <button type="button" class="kp-btn kp-btn-outline" data-link="{{ route('kms.index') }}" onclick="kpSalinLink(this)">Salin Link KMS</button>
    </div>
</div>

<div class="kp-search">
    <input type="search" id="kpSearch" placeholder="Cari dokumen atau kategori..." autocomplete="off">
</div>

<div id="kpHasil" class="kp-card" style="display:none;">
    <div class="kp-group-title" id="kpHasilInfo"></div>
    <table class="kp-table">
        <thead><tr><th>Judul</th><th>Sumber</th><th>Lokasi</th><th style="width:150px;">Aksi</th></tr></thead>
        <tbody id="kpHasilBody"></tbody>
    </table>
</div>

<div id="kpPanel" class="kp-panel">
    <div class="kp-upload-grid">
        <div class="kp-upload-card">
            <h3>Dokumen KMS</h3>
            <p class="kp-desc">Pilih subkategori, isi judul, unggah filenya.</p>
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
        </div>

        <div class="kp-upload-card">
            <h3>Dokumen Pedoman</h3>
            <p class="kp-desc">Pilih kategori, isi judul, unggah filenya.</p>
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
        </div>
    </div>
</div>

<div class="kp-section-head">
    <h2>Kategori KMS</h2>
    <p>{{ $kmsKategoris->count() }} kategori &middot; {{ $kmsDokumens->count() }} dokumen</p>
</div>
<div class="kp-card">
    <table class="kp-table">
        <thead><tr><th>Nama Kategori</th><th>Jumlah Dokumen</th><th style="width:200px;">Aksi</th></tr></thead>
        <tbody>
            @forelse ($kmsKategoris as $kategori)
            <tr data-cari="{{ mb_strtolower($kategori->nama) }}">
                <td>{{ $kategori->nama }}</td>
                <td>{{ $kmsDokumens->where('kategori_id', $kategori->id)->count() }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.kms.kategori.show', $kategori) }}" class="kp-btn kp-btn-outline">Kelola</a>
                    <x-btn-edit :href="route('admin.kms.kategori.edit', $kategori)" />
                    <x-btn-hapus :action="route('admin.kms.kategori.destroy', $kategori)" konfirmasi="Hapus kategori ini beserta semua isinya?" />
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="kp-empty">Belum ada kategori KMS.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="kp-section-head">
    <h2>Pedoman</h2>
    <p>{{ $pedomanKategoris->count() }} kategori &middot; {{ $pedomanDokumens->count() }} dokumen</p>
</div>
<div class="kp-card">
    <table class="kp-table">
        <thead><tr><th>Nama Kategori</th><th>Jumlah Dokumen</th><th style="width:200px;">Aksi</th></tr></thead>
        <tbody>
            @forelse ($pedomanKategoris as $kategori)
            <tr data-cari="{{ mb_strtolower($kategori->nama) }}">
                <td>{{ $kategori->nama }}</td>
                <td>{{ $pedomanDokumens->where('pedoman_kategori_id', $kategori->id)->count() }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.pedoman.kategori.show', $kategori) }}" class="kp-btn kp-btn-outline">Kelola</a>
                    <x-btn-edit :href="route('admin.pedoman.kategori.edit', $kategori)" />
                    <x-btn-hapus :action="route('admin.pedoman.kategori.destroy', $kategori)" konfirmasi="Hapus kategori pedoman ini beserta semua isinya?" />
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="kp-empty">Belum ada kategori Pedoman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function kpTogglePanel() {
    var p = document.getElementById('kpPanel');
    p.classList.toggle('open');
    if (p.classList.contains('open')) { p.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
}
function kpSalinLink(btn) {
    var link = btn.getAttribute('data-link');
    var teks = btn.textContent;
    function selesai() { btn.textContent = 'Link tersalin'; setTimeout(function () { btn.textContent = teks; }, 1800); }
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(link).then(selesai);
    } else {
        var t = document.createElement('textarea');
        t.value = link; document.body.appendChild(t); t.select();
        document.execCommand('copy'); document.body.removeChild(t); selesai();
    }
}
(function () {
    var DOCS = @json($kpDocs);
    var ICO_EDIT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>';
    var input = document.getElementById('kpSearch');
    var box = document.getElementById('kpHasil');
    var body = document.getElementById('kpHasilBody');
    var info = document.getElementById('kpHasilInfo');

    function esc(s) { var d = document.createElement('div'); d.textContent = (s == null ? '' : s); return d.innerHTML; }
    function attr(s) { return esc(s).replace(/"/g, '&quot;'); }

    input.addEventListener('input', function () {
        var q = input.value.trim().toLowerCase();

        document.querySelectorAll('tr[data-cari]').forEach(function (tr) {
            tr.style.display = (!q || tr.getAttribute('data-cari').indexOf(q) !== -1) ? '' : 'none';
        });

        if (!q) { box.style.display = 'none'; body.innerHTML = ''; return; }

        var hasil = DOCS.filter(function (d) {
            return (d.judul + ' ' + d.lokasi).toLowerCase().indexOf(q) !== -1;
        });

        info.textContent = hasil.length + ' dokumen ditemukan' + (hasil.length > 50 ? ' (50 pertama ditampilkan)' : '');
        body.innerHTML = hasil.length ? hasil.slice(0, 50).map(function (d) {
            return '<tr><td>' + esc(d.judul) + '</td><td>' + esc(d.sumber) + '</td><td>' + esc(d.lokasi) + '</td>' +
                '<td class="row-actions"><a href="' + attr(d.lihat) + '" target="_blank" class="kp-btn kp-btn-outline">Lihat</a>' +
                '<a href="' + attr(d.edit) + '" class="btn-icon" title="Edit" aria-label="Edit">' + ICO_EDIT + '</a></td></tr>';
        }).join('') : '<tr><td colspan="4" class="kp-empty">Tidak ada dokumen yang cocok.</td></tr>';
        box.style.display = 'block';
    });
})();
</script>
@endsection