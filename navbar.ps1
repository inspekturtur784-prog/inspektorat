$root  = "C:\xampp\htdocs\inspektorat"
$f     = "$root\resources\views\layouts\app.blade.php"
$utf8  = New-Object System.Text.UTF8Encoding($false)
$lines = [IO.File]::ReadAllLines($f)

$s = -1
for ($i = 0; $i -lt $lines.Count; $i++) {
  if ($lines[$i] -match "url\('/layanan/konsultansi'\)") { $s = $i; break }
}
if ($s -lt 0) { Write-Host "Link konsultansi tidak ditemukan (mungkin sudah diubah)." -ForegroundColor Yellow; return }

$e = -1
for ($j = $s; $j -lt $lines.Count; $j++) {
  if ($lines[$j] -match 'class="dropdown-divider"') { $e = $j; break }
}
if ($e -lt 0 -or ($e - $s) -gt 20) { Write-Host "Garis pemisah tidak ditemukan wajar, TIDAK diubah." -ForegroundColor Red; return }

$blok = ($lines[$s..$e]) -join "`n"
if ($blok -notmatch "knowledge-base" -or $blok -notmatch "'/buletin'") {
  Write-Host "Isi blok tidak sesuai dugaan, TIDAK diubah." -ForegroundColor Red; return
}

Write-Host "Baris yang akan DIHAPUS ($($s+1) sampai $($e+1)):" -ForegroundColor Cyan
for ($k = $s; $k -le $e; $k++) { Write-Host ("{0,4}: {1}" -f ($k+1), $lines[$k]) }

if ((Read-Host "Lanjut? (y/n)") -ne 'y') { Write-Host "Dibatalkan."; return }

Copy-Item $f "$f.bak" -Force
$baru = New-Object System.Collections.Generic.List[string]
for ($k = 0; $k -lt $lines.Count; $k++) {
  if ($k -ge $s -and $k -le $e) { continue }
  $baru.Add($lines[$k])
}
[IO.File]::WriteAllLines($f, $baru, $utf8)
Write-Host "Selesai. Backup: $f.bak" -ForegroundColor Green
php "$root\artisan" view:clear