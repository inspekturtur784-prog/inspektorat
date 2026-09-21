# Sambungkan footer publik ke Pengaturan Situs (Laravel Inspektorat)
# Jalankan dari folder project. Aman dijalankan ulang.
# File lama dibackup dulu (.bak_footer). Kalau pola footer tidak cocok, file itu TIDAK diubah.

$utf8 = New-Object System.Text.UTF8Encoding($false)
$root = (Get-Location).Path

if (-not (Test-Path (Join-Path $root 'artisan'))) {
    Write-Host "BERHENTI: jalankan dari folder project (C:\xampp\htdocs\inspektorat)." -ForegroundColor Red
    exit 1
}

$nd = [string][char]0x2013   # tanda "-" panjang (en dash), supaya script ini tetap ASCII

# ---------------------------------------------------------------
# 1) KELAS PEMBANTU: nilai bawaan = isi footer yang sekarang berjalan
# ---------------------------------------------------------------
$kelas = @'
<?php

namespace App\Support;

use App\Models\PengaturanProfil;

/**
 * Info kontak & media sosial untuk footer.
 * Nilai bawaan = isi footer sebelum dibuat dinamis, jadi tampilan tidak berubah
 * sampai admin menyimpan Pengaturan Situs.
 */
class SitusInfo
{
    public static function bawaan(): array
    {
        return [
            'kontak_alamat'      => 'Jl. Benteng Pancasila No. 23, Magersari, Kota Mojokerto, Jawa Timur 61314',
            'kontak_telepon'     => '(0321) 399630',
            'kontak_email'       => 'inspektorat@mojokertokota.go.id',
            'kontak_jam_layanan' => "Senin __ND__ Kamis\n07.30 __ND__ 15.30 WIB\n\nJumat\n07.30 __ND__ 14.30 WIB\n\nSabtu, Minggu & Libur Nasional\nTutup",
            'kontak_maps_embed'  => 'https://www.google.com/maps?q=Jl.+Benteng+Pancasila+No.+23,+Magersari,+Kota+Mojokerto,+Jawa+Timur+61314&output=embed',
            'sosmed_facebook'    => '',
            'sosmed_instagram'   => 'https://www.instagram.com/inspektoratkotamr',
            'sosmed_youtube'     => '',
        ];
    }

    public static function semua(): array
    {
        $hasil = self::bawaan();

        try {
            $tersimpan = PengaturanProfil::semua();
        } catch (\Throwable $e) {
            $tersimpan = [];
        }

        foreach ($hasil as $key => $nilai) {
            if (array_key_exists($key, $tersimpan)) {
                $hasil[$key] = (string) $tersimpan[$key];
            }
        }

        return $hasil;
    }
}
'@
$kelas = $kelas.Replace('__ND__', $nd)

$kelasPath = Join-Path $root 'app\Support\SitusInfo.php'
if (Test-Path $kelasPath) {
    "SUDAH ADA, dilewati: app\Support\SitusInfo.php"
} else {
    New-Item -ItemType Directory -Force -Path (Split-Path $kelasPath) | Out-Null
    [System.IO.File]::WriteAllText($kelasPath, $kelas, $utf8)
    "Dibuat: app\Support\SitusInfo.php"
}
if (-not (Test-Path $kelasPath)) {
    Write-Host "BERHENTI: SitusInfo.php gagal dibuat." -ForegroundColor Red
    exit 1
}

composer dump-autoload

# ---------------------------------------------------------------
# 2) HALAMAN PENGATURAN SITUS: form terisi nilai footer sekarang
#    (ini file baru buatan kita, bukan kode lama)
# ---------------------------------------------------------------
$pc = Join-Path $root 'app\Http\Controllers\Admin\PengaturanSitusController.php'
$t = [System.IO.File]::ReadAllText($pc)
if ($t.Contains('SitusInfo::semua()')) {
    "Controller Pengaturan Situs sudah memakai SitusInfo, dilewati"
} elseif ($t.Contains('PengaturanProfil::semua()')) {
    [System.IO.File]::WriteAllText($pc, $t.Replace('PengaturanProfil::semua()', '\App\Support\SitusInfo::semua()'), $utf8)
    "Controller Pengaturan Situs diperbarui"
} else {
    "Controller Pengaturan Situs: teks yang dicari tidak ditemukan, dilewati"
}

$pv = Join-Path $root 'resources\views\admin\pengaturan-situs\edit.blade.php'
$t = [System.IO.File]::ReadAllText($pv)
$lama = "'kontak_jam_layanan' => ['Jam layanan (contoh: Senin - Jumat, 07.30 - 16.00 WIB)', 'text'],"
$baru = "'kontak_jam_layanan' => ['Jam layanan (satu baris per keterangan, kosongkan satu baris untuk memisahkan hari)', 'textarea'],"
if ($t.Contains($lama)) {
    $t = $t.Replace($lama, $baru).Replace('rows="3"', 'rows="6"')
    [System.IO.File]::WriteAllText($pv, $t, $utf8)
    "View Pengaturan Situs: kolom jam layanan jadi beberapa baris"
} else {
    "View Pengaturan Situs: sudah diubah / teks tidak ditemukan, dilewati"
}

# ---------------------------------------------------------------
# 3) FUNGSI PASANG KE FOOTER (semua atau tidak sama sekali per file)
# ---------------------------------------------------------------
function Terapkan($rel, $daftar) {
    $file = Join-Path $root $rel
    if (-not (Test-Path $file)) { "TIDAK ADA: $rel"; return }
    $t = [System.IO.File]::ReadAllText($file)

    if ($t.Contains('SitusInfo::semua()')) { "SUDAH DIPASANG, dilewati: $rel"; return }

    $n = $t
    $gagal = @()
    foreach ($d in $daftar) {
        $cocok = [regex]::Matches($n, $d.Pola).Count
        if ($cocok -ne 1) {
            $gagal += "  - $($d.Nama): ditemukan $cocok, seharusnya 1"
            continue
        }
        $ganti = $d.Baru
        $n = [regex]::Replace($n, $d.Pola, { param($m) $ganti })
    }

    if ($gagal.Count -gt 0) {
        Write-Host "TIDAK DIUBAH ($rel), pola tidak cocok:" -ForegroundColor Yellow
        $gagal
        return
    }

    $bak = "$file.bak_footer"
    if (-not (Test-Path $bak)) { Copy-Item $file $bak }
    [System.IO.File]::WriteAllText($file, $n, $utf8)
    Write-Host "DIPASANG: $rel" -ForegroundColor Green
}

$svgFb = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 4h-2a4 4 0 0 0-4 4v2H7v3h2v7h3v-7h2.5l.5-3H12V8a1 1 0 0 1 1-1h2V4z"/></svg>'
$svgYt = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2.5" y="6" width="19" height="12" rx="3"/><path d="M10.5 9.5l5 2.5-5 2.5z" fill="currentColor" stroke="none"/></svg>'

$awal = "@php `$situs = \App\Support\SitusInfo::semua(); @endphp`r`n<footer>"

# ---------------------------------------------------------------
# 4) FOOTER layouts\app.blade.php
# ---------------------------------------------------------------
$appPeta = @'
@if ($situs['kontak_maps_embed'] !== '')
                    <div class="footer-map">
                        <iframe
                            src="{{ $situs['kontak_maps_embed'] }}"
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Kantor Inspektorat Kota Mojokerto"></iframe>
                    </div>
                    @endif
'@

$appKontak = @'
<h4>Kontak</h4>
                    <ul>
                        @if ($situs['kontak_alamat'] !== '')<li>{{ $situs['kontak_alamat'] }}</li>@endif
                        @if ($situs['kontak_email'] !== '')<li>{{ $situs['kontak_email'] }}</li>@endif
                        @if ($situs['kontak_telepon'] !== '')<li>{{ $situs['kontak_telepon'] }}</li>@endif
                    </ul>
'@

$appSosial = @'
<div class="footer-social" aria-label="Media sosial">
                        @if ($situs['sosmed_facebook'] !== '')
                        <a href="{{ $situs['sosmed_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook">
                            __SVG_FB__
                        </a>
                        @endif
                        @if ($situs['sosmed_instagram'] !== '')
                        <a href="{{ $situs['sosmed_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                        </a>
                        @endif
                        @if ($situs['sosmed_youtube'] !== '')
                        <a href="{{ $situs['sosmed_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube" title="YouTube">
                            __SVG_YT__
                        </a>
                        @endif
                    </div>
'@
$appSosial = $appSosial.Replace('__SVG_FB__', $svgFb).Replace('__SVG_YT__', $svgYt)

$appJam = @'
@if ($situs['kontak_jam_layanan'] !== '')
                <div class="footer-hours">
                    <strong>Jam Layanan</strong>
                    {!! nl2br(e($situs['kontak_jam_layanan'])) !!}
                </div>
                @endif
'@

$daftarApp = @(
    @{ Nama = 'awal footer';  Pola = '<footer>';                                       Baru = $awal },
    @{ Nama = 'peta';         Pola = '(?s)<div class="footer-map">.*?</iframe>\s*</div>'; Baru = $appPeta },
    @{ Nama = 'kontak';       Pola = '(?s)<h4>Kontak</h4>\s*<ul>.*?</ul>';             Baru = $appKontak },
    @{ Nama = 'media sosial'; Pola = '(?s)<div class="footer-social"[^>]*>.*?</div>';  Baru = $appSosial },
    @{ Nama = 'jam layanan';  Pola = '(?s)<div class="footer-hours">.*?</div>';        Baru = $appJam }
)
Terapkan 'resources\views\layouts\app.blade.php' $daftarApp

# ---------------------------------------------------------------
# 5) FOOTER beranda.blade.php (yang tadinya berisi data contoh)
# ---------------------------------------------------------------
$berSosial = @'
<div class="foot-social">
          @if ($situs['sosmed_facebook'] !== '')
          <a href="{{ $situs['sosmed_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook">
            __SVG_FB__
          </a>
          @endif
          @if ($situs['sosmed_instagram'] !== '')
          <a href="{{ $situs['sosmed_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
          </a>
          @endif
          @if ($situs['sosmed_youtube'] !== '')
          <a href="{{ $situs['sosmed_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube">
            __SVG_YT__
          </a>
          @endif
        </div>
'@
$berSosial = $berSosial.Replace('__SVG_FB__', $svgFb).Replace('__SVG_YT__', $svgYt)

$berKontak = @'
<h5>Kontak</h5>
        @if ($situs['kontak_alamat'] !== '')
        <a href="#">{{ $situs['kontak_alamat'] }}</a>
        @endif
        @if ($situs['kontak_telepon'] !== '')
        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $situs['kontak_telepon']) }}">{{ $situs['kontak_telepon'] }}</a>
        @endif
        @if ($situs['kontak_email'] !== '')
        <a href="mailto:{{ $situs['kontak_email'] }}">{{ $situs['kontak_email'] }}</a>
        @endif
      
'@

$daftarBeranda = @(
    @{ Nama = 'awal footer';  Pola = '<footer>';                                    Baru = $awal },
    @{ Nama = 'media sosial'; Pola = '(?s)<div class="foot-social">.*?</div>';      Baru = $berSosial },
    @{ Nama = 'kontak';       Pola = '(?s)<h5>Kontak</h5>.*?(?=</div>)';            Baru = $berKontak }
)
Terapkan 'resources\views\beranda.blade.php' $daftarBeranda

# ---------------------------------------------------------------
# 6) CACHE + CEK
# ---------------------------------------------------------------
php artisan view:clear
""
"Cek hasil:"
Select-String -Path (Join-Path $root 'resources\views\layouts\app.blade.php'), (Join-Path $root 'resources\views\beranda.blade.php') -Pattern 'SitusInfo::semua' | Select-Object Path, LineNumber
Write-Host "SELESAI. Refresh browser dengan Ctrl+F5." -ForegroundColor Green
