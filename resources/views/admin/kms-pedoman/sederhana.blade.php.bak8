@extends('admin.layout')
@section('title', 'KMS')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin-masterweb.css') }}">
@if ($errors->any())
<div class="admin-alert" style="background:#fdecea;color:#a12622;border-color:#f5c6cb">
    @foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach
</div>
@endif
<style>
    .mw-form{display:grid;grid-template-columns:1.4fr 1.4fr 1.2fr auto;gap:12px;padding:16px;align-items:end}
    @media (max-width:900px){.mw-form{grid-template-columns:1fr}}
    .mw-form label{display:block;font-size:13px;font-weight:600;color:#555;margin-bottom:5px}
    .mw-form input,.mw-form select{width:100%;padding:9px 10px;border:1px solid #ccc;border-radius:4px;font-size:14px;box-sizing:border-box;font-family:inherit;background:#fff}
    .mw-save{background:#5cb85c;color:#fff;border:0;border-radius:4px;padding:10px 22px;font-weight:700;cursor:pointer;font-family:inherit}
    .mw-hint{padding:0 16px 14px;font-size:12px;color:#888}
    .mw-links{display:flex;gap:14px;align-items:center;flex-wrap:wrap}
    .mw-links a,.mw-links button{font-size:13px;color:#1c6ea4;background:none;border:0;cursor:pointer;padding:0;font-family:inherit;text-decoration:underline}
</style>

<div class="kp-header">
    <h1>KMS</h1>
    <div class="mw-links">
        <button type="button" data-link="{{ route('kms.index') }}" onclick="mwSalinLink(this)">Salin Link KMS</button>
        <a href="{{ Route::has('admin.kms.kelola') ? route('admin.kms.kelola') : route('admin.kms.index') }}">Kelola Kategori</a>
    </div>
</div>

<div class="mw-box">
    <div class="mw-box-head"><span>Entri Dokumen</span></div>
    <form id="mwForm" method="POST" enctype="multipart/form-data" class="mw-form">
        @csrf
        <input type="hidden" id="mwHidden" value="">
        <div>
            <label>Kategori</label>
            <select id="mwKat" required>
                <option value="">-- Pilih Kategori --</option>
                <optgroup label="KMS">
                    @foreach ($subkategoris->sortBy(fn($s) => ($s->kategori->nama ?? '') . $s->nama) as $s)
                        <option value="kms:{{ $s->id }}">{{ $s->kategori->nama ?? '-' }} / {{ $s->nama }}</option>
                    @endforeach
                </optgroup>
                <optgroup label="Pedoman (khusus petugas)">
                    @foreach ($pedomanKategoris as $k)
                        <option value="pedoman:{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        <div>
            <label>Judul Dokumen</label>
            <input type="text" name="judul" required>
        </div>
        <div>
            <label>File</label>
            <input type="file" name="file" accept="application/pdf,video/*" required>
        </div>
        <div><button type="submit" class="mw-save">Simpan</button></div>
    </form>
    <div class="mw-hint">KMS: PDF atau video (maks 100MB). Pedoman: PDF saja (maks 20MB).</div>
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
                    <th data-sort="1">Tanggal</th>
                    <th data-sort="2">Judul</th>
                    <th data-sort="3">Sumber</th>
                    <th data-sort="4">Kategori</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $r)
                <tr data-cari="{{ mb_strtolower($r['judul'] . ' ' . $r['sumber'] . ' ' . $r['kategori']) }}">
                    <td class="mw-no"></td>
                    <td data-v="{{ $r['ts'] }}">{{ $r['ts'] ? \Carbon\Carbon::createFromTimestamp($r['ts'])->format('d-m-Y') : '-' }}</td>
                    <td>{{ $r['judul'] }}</td>
                    <td><span class="mw-badge mw-{{ strtolower($r['sumber']) }}">{{ $r['sumber'] }}</span></td>
                    <td>{{ $r['kategori'] }}</td>
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
    var URL_KMS = @json(route('admin.kms.dokumen.store'));
    var URL_PED = @json(route('admin.pedoman.dokumen.store'));
    var form = document.getElementById('mwForm');
    form.addEventListener('submit', function () {
        var p = document.getElementById('mwKat').value.split(':');
        var h = document.getElementById('mwHidden');
        if (p[0] === 'pedoman') { form.action = URL_PED; h.name = 'pedoman_kategori_id'; }
        else { form.action = URL_KMS; h.name = 'subkategori_id'; }
        h.value = p[1] || '';
    });

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
        if (col === 1) { return Number(td.getAttribute('data-v')) || 0; }
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