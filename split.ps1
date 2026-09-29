$root = "C:\xampp\htdocs\inspektorat"
$pub  = "$root\public"
$f    = "$pub\css\mengenal-kartu.css"

$img = Get-ChildItem "$pub\images","$pub\storage" -Recurse -File -ErrorAction SilentlyContinue |
  Where-Object { $_.Extension -match '^\.(jpg|jpeg|png|webp)$' -and $_.Name -notmatch 'logo|favicon|icon' } |
  Select-Object -First 40

if (-not $img) { Write-Host "Tidak ada gambar ditemukan di public\images atau public\storage." -ForegroundColor Red; return }

Write-Host "Pilih foto untuk sisi kanan:" -ForegroundColor Cyan
for ($i = 0; $i -lt $img.Count; $i++) {
  Write-Host ("{0,3}: {1}" -f ($i+1), $img[$i].FullName.Replace("$pub\",""))
}
$n = [int](Read-Host "Nomor foto")
if ($n -lt 1 -or $n -gt $img.Count) { Write-Host "Nomor tidak valid, dibatalkan."; return }

$rel = $img[$n-1].FullName.Replace("$pub\","").Replace("\","/").Replace(" ","%20")

Copy-Item $f "$f.bak3" -Force
$isi = [IO.File]::ReadAllText($f)
$isi = [regex]::Replace($isi, '(?s)\r?\n/\* SPLIT LAYOUT \*/.*$', '')

$blok = @'

/* SPLIT LAYOUT */
.ins-about .ins-about-inner {
  display: grid;
  grid-template-columns: 1fr 1fr;
  column-gap: 56px;
}
.ins-about .ins-about-intro { grid-column: 1; grid-row: 1; max-width: none; align-self: center; }
.ins-about .ins-about-grid {
  grid-column: 1 / -1;
  grid-row: 2;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
}
.ins-about .ins-about-inner::after {
  content: "";
  grid-column: 2;
  grid-row: 1;
  min-height: 340px;
  margin-bottom: 44px;
  border-radius: 16px;
  background: url('../__FOTO__') center 30% / cover no-repeat;
  box-shadow: 0 18px 40px -20px rgba(11,37,69,.35);
}
@media (max-width: 900px) {
  .ins-about .ins-about-inner { grid-template-columns: 1fr; }
  .ins-about .ins-about-intro { grid-row: 1; }
  .ins-about .ins-about-inner::after { grid-column: 1; grid-row: 2; min-height: 240px; margin-bottom: 32px; }
  .ins-about .ins-about-grid { grid-row: 3; }
}
'@
$blok = $blok.Replace("__FOTO__", $rel)

[IO.File]::WriteAllText($f, $isi + $blok, (New-Object System.Text.UTF8Encoding($false)))
Write-Host "Selesai. Foto: $rel  |  Backup: $f.bak3" -ForegroundColor Green
php "$root\artisan" view:clear