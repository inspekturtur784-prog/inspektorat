$root = "C:\xampp\htdocs\inspektorat"
$utf8 = New-Object System.Text.UTF8Encoding($false)

# 1. Partial baru (file baru)
$partial = @'
@php
    $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                  7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];

    $arsip = \App\Models\Article::selectRaw('YEAR(COALESCE(published_at, created_at)) as tahun, MONTH(COALESCE(published_at, created_at)) as bulan, COUNT(*) as total')
        ->groupBy('tahun', 'bulan')
        ->orderByDesc('tahun')
        ->orderByDesc('bulan')
        ->get();

    $tahunAktif    = request('tahun');
    $bulanAktif    = request('bulan');
    $tahunTersedia = $arsip->pluck('tahun')->unique()->values();
    $sedangFilter  = request()->filled('tahun') || request()->filled('bulan');
@endphp

<style>
.arsip-box { background:#fff; border:1px solid #e3e8ef; border-radius:12px; padding:20px 22px; margin-bottom:22px; }
.arsip-box h2 { font-size:16px; margin:0 0 14px; color:#0b2545; }
.arsip-filter { display:flex; flex-wrap:wrap; gap:10px; align-items:center; margin-bottom:16px; }
.arsip-filter select { padding:8px 10px; border:1px solid #cfd8e3; border-radius:8px; background:#fff; font-size:14px; }
.arsip-filter .arsip-btn { padding:8px 16px; border-radius:8px; border:0; background:#0b2545; color:#fff; font-size:14px; cursor:pointer; }
.arsip-filter .arsip-reset { font-size:14px; color:#5b6b7f; text-decoration:underline; }
.arsip-tahun { font-size:13px; font-weight:700; color:#8a6d12; letter-spacing:.06em; margin:12px 0 6px; }
.arsip-chips { display:flex; flex-wrap:wrap; gap:8px; }
.arsip-chip { display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border:1px solid #cfd8e3; border-radius:999px; text-decoration:none; color:#0b2545; font-size:13.5px; background:#f7f9fc; }
.arsip-chip span { background:#0b2545; color:#fff; border-radius:999px; padding:1px 8px; font-size:12px; }
.arsip-chip:hover { border-color:#c9a227; }
.arsip-chip.aktif { background:#0b2545; color:#fff; border-color:#0b2545; }
.arsip-chip.aktif span { background:#c9a227; color:#0b2545; }
.arsip-info { margin:0 0 4px; font-size:14px; color:#0b2545; }
</style>

<div class="arsip-box">
    <h2>Arsip Artikel</h2>

    <form method="GET" action="{{ route('admin.articles.index') }}" class="arsip-filter">
        <select name="tahun">
            <option value="">Semua tahun</option>
            @foreach ($tahunTersedia as $t)
                <option value="{{ $t }}" {{ (string) $tahunAktif === (string) $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
        <select name="bulan">
            <option value="">Semua bulan</option>
            @foreach ($namaBulan as $n => $nama)
                <option value="{{ $n }}" {{ (string) $bulanAktif === (string) $n ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>
        <button type="submit" class="arsip-btn">Terapkan</button>
        @if ($sedangFilter)
            <a href="{{ route('admin.articles.index') }}" class="arsip-reset">Reset</a>
        @endif
    </form>

    @if ($sedangFilter)
        <p class="arsip-info">
            Menampilkan
            <strong>{{ $bulanAktif ? ($namaBulan[(int) $bulanAktif] ?? '') : 'semua bulan' }}{{ $tahunAktif ? ' '.$tahunAktif : '' }}</strong>:
            {{ $articles->total() }} artikel
        </p>
    @endif

    @foreach ($arsip->groupBy('tahun') as $tahun => $baris)
        <div class="arsip-tahun">{{ $tahun }} &middot; {{ $baris->sum('total') }} artikel</div>
        <div class="arsip-chips">
            @foreach ($baris as $r)
                @php $aktif = (string) $tahunAktif === (string) $r->tahun && (string) $bulanAktif === (string) $r->bulan; @endphp
                <a href="{{ route('admin.articles.index', ['tahun' => $r->tahun, 'bulan' => $r->bulan]) }}" class="arsip-chip {{ $aktif ? 'aktif' : '' }}">
                    {{ $namaBulan[(int) $r->bulan] }} <span>{{ $r->total }}</span>
                </a>
            @endforeach
        </div>
    @endforeach
</div>
'@
[IO.File]::WriteAllText("$root\resources\views\admin\articles\_arsip.blade.php", $partial, $utf8)
Write-Host "Partial dibuat." -ForegroundColor Green

# 2. Rencana perubahan
$ctl  = "$root\app\Http\Controllers\Admin\ArticleController.php"
$view = "$root\resources\views\admin\articles\index.blade.php"

$t   = [IO.File]::ReadAllText($ctl)
$old = "`$articles = Article::orderByDesc('created_at')->paginate(10);"

if ($t -like "*YEAR(COALESCE*") {
  Write-Host "Controller sudah berisi filter, dilewati." -ForegroundColor Yellow
  $ctlOk = $false
} elseif ($t.IndexOf($old) -lt 0) {
  Write-Host "Baris paginate(10) di controller tidak ditemukan, TIDAK diubah." -ForegroundColor Red
  $ctlOk = $false
} else { $ctlOk = $true }

$lines = [IO.File]::ReadAllLines($view)
$idx = -1
for ($i = 0; $i -lt $lines.Count; $i++) { if ($lines[$i] -match '<table class="admin-table">') { $idx = $i; break } }
if (($lines -join "`n") -like "*admin.articles._arsip*") {
  Write-Host "View sudah berisi include, dilewati." -ForegroundColor Yellow
  $viewOk = $false
} elseif ($idx -lt 0) {
  Write-Host "Tag tabel tidak ditemukan di view, TIDAK diubah." -ForegroundColor Red
  $viewOk = $false
} else { $viewOk = $true }

if (-not ($ctlOk -or $viewOk)) { php "$root\artisan" view:clear; return }

Write-Host "`nYang akan diubah:" -ForegroundColor Cyan
if ($ctlOk)  { Write-Host "  Controller: baris  $old  diganti versi dengan filter tahun/bulan (tanpa filter hasilnya sama)." }
if ($viewOk) { Write-Host "  View: @include('admin.articles._arsip') disisipkan sebelum baris $($idx+1) ($($lines[$idx].Trim()))" }

if ((Read-Host "Lanjut? (y/n)") -ne 'y') { Write-Host "Dibatalkan."; return }

# 3. Terapkan (backup dulu)
if ($ctlOk) {
  Copy-Item $ctl "$ctl.bak" -Force
  $nl = if ($t.Contains("`r`n")) { "`r`n" } else { "`n" }
  $new = @(
    "`$articles = Article::orderByDesc('created_at')",
    "            ->when(request()->filled('tahun'), fn (`$q) => `$q->whereRaw('YEAR(COALESCE(published_at, created_at)) = ?', [(int) request('tahun')]))",
    "            ->when(request()->filled('bulan'), fn (`$q) => `$q->whereRaw('MONTH(COALESCE(published_at, created_at)) = ?', [(int) request('bulan')]))",
    "            ->paginate(10)",
    "            ->withQueryString();"
  ) -join $nl
  [IO.File]::WriteAllText($ctl, $t.Replace($old, $new), $utf8)
  Write-Host "Controller diubah. Backup: $ctl.bak" -ForegroundColor Green
}
if ($viewOk) {
  Copy-Item $view "$view.bak" -Force
  $baru = New-Object System.Collections.Generic.List[string]
  for ($k = 0; $k -lt $lines.Count; $k++) {
    if ($k -eq $idx) { $baru.Add("@include('admin.articles._arsip')"); $baru.Add("") }
    $baru.Add($lines[$k])
  }
  [IO.File]::WriteAllLines($view, $baru, $utf8)
  Write-Host "View diubah. Backup: $view.bak" -ForegroundColor Green
}
php "$root\artisan" view:clear