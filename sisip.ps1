$root  = "C:\xampp\htdocs\inspektorat"
$f     = "$root\resources\views\home.blade.php"
$utf8  = New-Object System.Text.UTF8Encoding($false)
$lines = [IO.File]::ReadAllLines($f)

if (($lines -join "`n") -like "*@include('partials.produk')*") {
  Write-Host "Include sudah ada, tidak diubah." -ForegroundColor Yellow; return
}

$idx = -1
for ($i = 0; $i -lt $lines.Count; $i++) {
  if ($lines[$i] -match '\{\{--.*MENGENAL KAMI.*--\}\}') { $idx = $i; break }
}
if ($idx -lt 0) { Write-Host "Komentar Blade tidak ditemukan." -ForegroundColor Red; return }

$end = -1
for ($j = $idx; $j -lt $lines.Count; $j++) {
  if ($lines[$j] -match '</section>') { $end = $j; break }
}
if ($end -lt 0) { Write-Host "</section> tidak ditemukan." -ForegroundColor Red; return }

Write-Host "Section mulai baris $($idx+1). Kartu disisipkan SETELAH baris $($end+1):" -ForegroundColor Cyan
for ($k = [Math]::Max(0,$end-3); $k -le [Math]::Min($lines.Count-1,$end+4); $k++) {
  $t = if ($k -eq $end) { ">>" } else { "  " }
  Write-Host ("{0} {1,4}: {2}" -f $t, ($k+1), $lines[$k])
}

if ((Read-Host "Lanjut? (y/n)") -ne 'y') { Write-Host "Dibatalkan."; return }

Copy-Item $f "$f.bak" -Force
$baru = New-Object System.Collections.Generic.List[string]
for ($k = 0; $k -lt $lines.Count; $k++) {
  $baru.Add($lines[$k])
  if ($k -eq $end) { $baru.Add(""); $baru.Add("@include('partials.produk')"); $baru.Add("") }
}
[IO.File]::WriteAllLines($f, $baru, $utf8)
Write-Host "Selesai. Backup: $f.bak" -ForegroundColor Green
php "$root\artisan" view:clear