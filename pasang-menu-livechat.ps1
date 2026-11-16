# =====================================================================
# pasang-menu-livechat.ps1
# Menambahkan menu "Live Chat" di sidebar admin Inspektorat dan membuat
# halaman live chat tampil di dalam layout admin (sidebar tetap ada).
#
# Jalankan dari ROOT proyek Laravel:
#   Set-ExecutionPolicy -Scope Process Bypass -Force
#   .\pasang-menu-livechat.ps1
#
# Yang dilakukan:
#   1. resources/views/admin/layout.blade.php
#        -> disisipkan 1 menu "Live Chat" tepat SETELAH menu "Pesan Masuk"
#        -> menu yang sudah ada tidak diubah. Backup: layout.blade.php.bak-menu
#   2. resources/views/livechat/admin/index.blade.php dan show.blade.php
#        -> file buatan install-livechat.ps1 diganti versi yang memakai
#           layout admin. Backup lama: *.bak-menu
#   Route, controller, dan fitur lain TIDAK diubah.
# =====================================================================

$ErrorActionPreference = 'Stop'

if (-not (Test-Path 'artisan')) {
    Write-Host 'ERROR: jalankan skrip ini dari root proyek Laravel (folder yang ada file artisan).' -ForegroundColor Red
    exit 1
}

$utf8 = New-Object System.Text.UTF8Encoding($false)

function Write-WithBackup($path, $content) {
    $full = Join-Path (Get-Location) $path
    $dir = Split-Path $full -Parent
    if (-not (Test-Path $dir)) { New-Item -ItemType Directory -Path $dir -Force | Out-Null }
    if (Test-Path $full) { Copy-Item $full "$full.bak-menu" -Force }
    [System.IO.File]::WriteAllText($full, $content, $utf8)
    Write-Host "OK   : $path" -ForegroundColor Green
}

# ---------------------------------------------------------------------
# 1. MENU DI SIDEBAR (sisip setelah menu "Pesan Masuk")
# ---------------------------------------------------------------------
$menuHtml = @'
{{-- LIVECHAT-MENU --}}
                    <a href="{{ url('/admin/live-chat') }}" class="{{ request()->is('admin/live-chat*') ? 'active' : '' }}" style="display:flex;justify-content:space-between;align-items:center;">
                        <span>Live Chat</span>
                        @php
                            $chatBaru = \Illuminate\Support\Facades\Schema::hasTable('livechat_threads')
                                ? \App\Models\LiveChatThread::where('status', 'baru')->count()
                                : 0;
                        @endphp
                        @if ($chatBaru > 0)
                            <span class="admin-nav-badge">{{ $chatBaru }}</span>
                        @endif
                    </a>
'@

$layoutPath = 'resources/views/admin/layout.blade.php'
$layoutFull = Join-Path (Get-Location) $layoutPath

if (-not (Test-Path $layoutFull)) {
    Write-Host "PERHATIAN: $layoutPath tidak ditemukan. Menu tidak dipasang." -ForegroundColor Yellow
} else {
    $c = [System.IO.File]::ReadAllText($layoutFull)
    if ($c -like '*LIVECHAT-MENU*') {
        Write-Host 'SKIP : menu Live Chat sudah ada di sidebar' -ForegroundColor Yellow
    } else {
        $a = $c.IndexOf('<span>Pesan Masuk</span>')
        if ($a -lt 0) {
            Write-Host 'PERHATIAN: menu "Pesan Masuk" tidak ditemukan di layout. Menu tidak dipasang.' -ForegroundColor Yellow
        } else {
            $e = $c.IndexOf('</a>', $a)
            if ($e -lt 0) {
                Write-Host 'PERHATIAN: penutup menu Pesan Masuk tidak ditemukan. Menu tidak dipasang.' -ForegroundColor Yellow
            } else {
                $e += 4
                Copy-Item $layoutFull "$layoutFull.bak-menu" -Force
                $c = $c.Substring(0, $e) + "`r`n" + $menuHtml.TrimEnd() + $c.Substring($e)
                [System.IO.File]::WriteAllText($layoutFull, $c, $utf8)
                Write-Host "OK   : menu Live Chat dipasang di $layoutPath (backup: $layoutPath.bak-menu)" -ForegroundColor Green
            }
        }
    }
}

# ---------------------------------------------------------------------
# 2. HALAMAN DAFTAR LIVE CHAT (memakai layout admin)
# ---------------------------------------------------------------------
$indexView = @'
@extends('admin.layout')
@section('title', 'Live Chat')

@section('content')
<div class="admin-header">
    <h1>Live Chat</h1>
</div>

@if(session('success'))
    <div style="background:#d1e7dd;color:#0f5132;padding:10px 14px;border-radius:8px;margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
    <a href="{{ url('/admin/live-chat') }}" class="btn-admin btn-admin-ghost">Semua</a>
    <a href="{{ url('/admin/live-chat?status=baru') }}" class="btn-admin btn-admin-ghost">Baru</a>
    <a href="{{ url('/admin/live-chat?status=dijawab') }}" class="btn-admin btn-admin-ghost">Dijawab</a>
    <a href="{{ url('/admin/live-chat?status=ditutup') }}" class="btn-admin btn-admin-ghost">Ditutup</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Pengguna</th>
            <th>Pesan Terakhir</th>
            <th>Status</th>
            <th>Waktu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($threads as $t)
            <tr>
                <td>
                    <strong>{{ $t->nama }}</strong>
                    @if($t->unread)
                        <span class="admin-nav-badge" style="margin-left:6px;">{{ $t->unread }}</span>
                    @endif
                    <br>
                    <small>{{ $t->email }}@if($t->telepon) &middot; {{ $t->telepon }}@endif</small>
                </td>
                <td>{{ \Illuminate\Support\Str::limit($t->last_body, 80) }}</td>
                <td>
                    @php
                        $warna = ['baru' => '#dc3545', 'dijawab' => '#198754', 'ditutup' => '#6c757d'][$t->status] ?? '#6c757d';
                    @endphp
                    <span style="display:inline-block;padding:2px 10px;border-radius:999px;font-size:12px;color:#fff;background:{{ $warna }};">{{ ucfirst($t->status) }}</span>
                </td>
                <td>{{ optional($t->last_message_at)->format('d/m/Y H:i') }}</td>
                <td class="row-actions">
                    <a href="{{ url('/admin/live-chat/'.$t->id) }}" class="btn-admin btn-admin-ghost">Buka &amp; Balas</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada live chat masuk.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $threads->links() }}</div>
@endsection
'@
Write-WithBackup 'resources/views/livechat/admin/index.blade.php' $indexView

# ---------------------------------------------------------------------
# 3. HALAMAN DETAIL + BALAS (memakai layout admin)
# ---------------------------------------------------------------------
$showView = @'
@extends('admin.layout')
@section('title', 'Live Chat - ' . $thread->nama)

@section('content')
<style>
.lc-box{max-width:780px}
.lc-info{color:#555;font-size:14px;margin:4px 0 16px}
.lc-msgs{height:400px;overflow:auto;background:#f3f5f9;border-radius:10px;padding:14px;border:1px solid #e3e6ee}
.lc-m{max-width:78%;margin-bottom:10px;padding:9px 12px;border-radius:12px;white-space:pre-wrap;word-wrap:break-word;line-height:1.5}
.lc-m.user{background:#fff;border:1px solid #dde}
.lc-m.admin{margin-left:auto;background:#0d6efd;color:#fff}
.lc-m small{display:block;opacity:.65;font-size:11px;margin-top:4px}
.lc-reply textarea{width:100%;box-sizing:border-box;border:1px solid #ccd;border-radius:10px;padding:10px;font:inherit;min-height:90px;margin-top:14px}
.lc-actions{display:flex;gap:10px;align-items:center;margin-top:10px;flex-wrap:wrap}
</style>

<div class="admin-header">
    <h1>Live Chat</h1>
</div>

<div class="lc-box">
    <a href="{{ url('/admin/live-chat') }}" class="btn-admin btn-admin-ghost">&larr; Kembali ke Live Chat</a>

    <h2 style="margin:18px 0 0;">{{ $thread->nama }}</h2>
    <div class="lc-info">
        {{ $thread->email }}@if($thread->telepon) &middot; {{ $thread->telepon }}@endif
        &middot; Status: <strong>{{ ucfirst($thread->status) }}</strong>
    </div>

    @if(session('success'))
        <div style="background:#d1e7dd;color:#0f5132;padding:10px 14px;border-radius:8px;margin-bottom:14px;">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div style="background:#f8d7da;color:#842029;padding:10px 14px;border-radius:8px;margin-bottom:14px;">{{ $errors->first() }}</div>
    @endif

    <div class="lc-msgs" id="lc-msgs">
        @foreach($messages as $m)
            <div class="lc-m {{ $m->sender }}">{{ $m->body }}<small>{{ $m->sender === 'admin' ? 'Admin' : $thread->nama }} - {{ $m->created_at->format('d/m/Y H:i') }}</small></div>
        @endforeach
    </div>

    @if($thread->status !== 'ditutup')
        <form method="POST" action="{{ url('/admin/live-chat/'.$thread->id.'/reply') }}" class="lc-reply">
            @csrf
            <textarea name="pesan" placeholder="Tulis balasan... (pengguna akan menerima email pemberitahuan)" required></textarea>
            <div class="lc-actions">
                <button type="submit" class="btn-admin">Kirim Balasan</button>
            </div>
        </form>

        <form method="POST" action="{{ url('/admin/live-chat/'.$thread->id.'/close') }}" style="margin-top:10px;" onsubmit="return confirm('Tutup konsultasi ini?');">
            @csrf
            <button type="submit" class="btn-admin btn-admin-danger">Tutup Konsultasi</button>
        </form>
    @else
        <p style="margin-top:16px;"><em>Konsultasi ini sudah ditutup.</em></p>
    @endif
</div>

<script>
(function () {
    var box = document.getElementById('lc-msgs');
    var last = {{ (int) optional($messages->last())->id }};
    var namaUser = @json($thread->nama);
    box.scrollTop = box.scrollHeight;

    function add(m) {
        if (m.id <= last) return;
        last = m.id;
        var d = document.createElement('div');
        d.className = 'lc-m ' + m.sender;
        d.textContent = m.body;
        var s = document.createElement('small');
        s.textContent = (m.sender === 'admin' ? 'Admin' : namaUser) + ' - ' + m.time;
        d.appendChild(s);
        box.appendChild(d);
        box.scrollTop = box.scrollHeight;
    }

    setInterval(function () {
        fetch('{{ url('/admin/live-chat/'.$thread->id.'/messages') }}?after=' + last, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (r) { return r.json(); }).then(function (j) {
            j.messages.forEach(add);
        }).catch(function () {});
    }, 5000);
})();
</script>
@endsection
'@
Write-WithBackup 'resources/views/livechat/admin/show.blade.php' $showView

# ---------------------------------------------------------------------
Write-Host ''
Write-Host 'SELESAI. Langkah berikutnya:' -ForegroundColor Cyan
Write-Host '  1. php artisan view:clear'
Write-Host '  2. Buka http://localhost/inspektorat/public/admin lalu tekan Ctrl+F5'
Write-Host '  3. Menu "Live Chat" muncul di sidebar, di bawah "Pesan Masuk"'
