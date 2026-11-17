@extends('admin.layout')
@section('title', 'KMS')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-masterweb.css') }}">
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

<div class="kp-header">
    <h1>KMS</h1>
    <div class="kp-top-actions">
        <button type="button" class="kp-btn kp-btn-primary" onclick="mwTogglePanel()">+ Tambah Dokumen</button>
        <a href="{{ route('admin.kms.kategori.create') }}" class="kp-btn kp-btn-outline">+ Kategori KMS</a>
        <a href="{{ route('admin.pedoman.kategori.create') }}" class="kp-btn kp-btn-outline">+ Kategori Pedoman</a>
        <a href="{{ route('admin.kms.kelola') }}" class="kp-btn kp-btn-outline">Kelola Kategori</a>
        <button type="button" class="kp-btn kp-btn-outline" data-link="{{ route('kms.index') }}" onclick="mwSalinLink(this)">Salin Link KMS</button>
    </div>
</div>

<div id="mwPanel" class="kp-panel">
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
                        @foreach ($subkategoris->sortBy(fn($s) => ($s->kategori->nama ?? '') . $s->nama)->groupBy(fn($s) => $s->kategori->nama ?? '-') as $namaKategori => $subs)
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
                        @foreach ($pedomanKategoris as $k)
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

<div class="mw-box">
    <div class="mw-box-head">
        <span>Daftar Dokumen ({{ $rows->count() }})</span>
        <select id="mwLen" aria-label="Jumlah baris">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="mw-toolbar">
        <input type="search" id="mwSearch" placeholder="Cari judul atau kategori..." autocomplete="off">
    </div>
    <div class="mw-scroll">
        <table class="mw-table" id="mwTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th data-sort="1">Judul</th>
                    <th data-sort="2">Sumber</th>
                    <th data-sort="3">Kategori</th>
                    <th data-sort="4">Tanggal</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $r)
                <tr data-cari="{{ mb_strtolower($r['judul'] . ' ' . $r['sumber'] . ' ' . $r['kategori']) }}">
                    <td class="mw-no"></td>
                    <td>{{ $r['judul'] }}</td>
                    <td><span class="mw-badge mw-{{ strtolower($r['sumber']) }}">{{ $r['sumber'] }}</span></td>
                    <td>{{ $r['kategori'] }}</td>
                    <td data-v="{{ $r['ts'] }}">{{ $r['ts'] ? \Carbon\Carbon::createFromTimestamp($r['ts'])->format('d-m-Y') : '-' }}</td>
                    <td><a href="{{ $r['file_url'] }}" target="_blank" rel="noopener">{{ strtoupper($r['tipe'] ?? 'file') }}</a></td>
                    <td class="row-actions">
                        <x-btn-edit :href="$r['edit_url']" />
                        <x-btn-hapus :action="$r['hapus_url']" konfirmasi="Hapus dokumen ini?" />
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="mw-empty">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mw-footer">
        <span id="mwInfo"></span>
        <span class="mw-pager">
            <button type="button" id="mwPrev">&laquo; Sebelumnya</button>
            <button type="button" id="mwNext">Berikutnya &raquo;</button>
        </span>
    </div>
</div>

<script>
function mwTogglePanel() {
    var p = document.getElementById('mwPanel');
    p.classList.toggle('open');
    if (p.classList.contains('open')) { p.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
}
function mwSalinLink(btn) {
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
    var tbody = document.querySelector('#mwTable tbody');
    var rows = Array.prototype.slice.call(tbody.querySelectorAll('tr[data-cari]'));
    if (!rows.length) { return; }
    var q = '', size = 10, page = 1, sortCol = null, asc = true;
    var elSearch = document.getElementById('mwSearch');
    var elLen = document.getElementById('mwLen');
    var elInfo = document.getElementById('mwInfo');
    var elPrev = document.getElementById('mwPrev');
    var elNext = document.getElementById('mwNext');

    function val(tr, col) {
        var td = tr.children[col];
        if (col === 4) { return Number(td.getAttribute('data-v')) || 0; }
        return td.textContent.trim().toLowerCase();
    }

    function render() {
        var list = rows.filter(function (r) { return !q || r.getAttribute('data-cari').indexOf(q) !== -1; });
        if (sortCol !== null) {
            list.sort(function (a, b) {
                var x = val(a, sortCol), y = val(b, sortCol);
                return (x < y ? -1 : (x > y ? 1 : 0)) * (asc ? 1 : -1);
            });
        }
        var pages = Math.max(1, Math.ceil(list.length / size));
        if (page > pages) { page = pages; }
        var start = (page - 1) * size;
        rows.forEach(function (r) { r.style.display = 'none'; });
        list.slice(start, start + size).forEach(function (r, i) {
            r.style.display = '';
            r.querySelector('.mw-no').textContent = start + i + 1;
            tbody.appendChild(r);
        });
        elInfo.textContent = list.length
            ? 'Menampilkan ' + (start + 1) + ' - ' + Math.min(start + size, list.length) + ' dari ' + list.length + ' dokumen'
            : 'Tidak ada dokumen yang cocok.';
        elPrev.disabled = page <= 1;
        elNext.disabled = page >= pages;
    }

    elSearch.addEventListener('input', function () { q = elSearch.value.trim().toLowerCase(); page = 1; render(); });
    elLen.addEventListener('change', function () { size = parseInt(elLen.value, 10) || 10; page = 1; render(); });
    elPrev.addEventListener('click', function () { if (page > 1) { page--; render(); } });
    elNext.addEventListener('click', function () { page++; render(); });
    document.querySelectorAll('#mwTable th[data-sort]').forEach(function (th) {
        th.addEventListener('click', function () {
            var c = parseInt(th.getAttribute('data-sort'), 10);
            asc = (sortCol === c) ? !asc : true;
            sortCol = c; page = 1; render();
        });
    });
    render();
})();
</script>
@endsection