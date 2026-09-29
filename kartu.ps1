$root = "C:\xampp\htdocs\inspektorat"
$utf8 = New-Object System.Text.UTF8Encoding($false)

# 1. CSS tambahan (file baru)
$css = @'
.ins-about .ins-about-card { position: relative; padding-top: 34px; }
.ins-about .ins-about-icon { display: none; }
.ins-about .ins-about-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 22px;
  width: 44px;
  height: 3px;
  background: #c9a227;
  border-radius: 0 0 3px 3px;
}
'@
[IO.File]::WriteAllText("$root\public\css\mengenal-kartu.css", $css, $utf8)

# 2. Sisipkan link di layout (setelah link produk.css)
$f     = "$root\resources\views\layouts\app.blade.php"
$lines = [IO.File]::ReadAllLines($f)

if (($lines -join "`n") -like "*mengenal-kartu.css*") {
  Write-Host "Link sudah ada, layout tidak diubah." -ForegroundColor Yellow
} else {
  $idx = -1
  for ($i = 0; $i -lt $lines.Count; $i++) {
    if ($lines[$i] -match 'css/produk\.css') { $idx = $i; break }
  }
  if ($idx -lt 0) {
    Write-Host "Link produk.css tidak ditemukan, layout TIDAK diubah." -ForegroundColor Red
  } else {
    Copy-Item $f "$f.bak2" -Force
    $baru = New-Object System.Collections.Generic.List[string]
    for ($k = 0; $k -lt $lines.Count; $k++) {
      $baru.Add($lines[$k])
      if ($k -eq $idx) { $baru.Add('<link rel="stylesheet" href="{{ asset(''css/mengenal-kartu.css'') }}">') }
    }
    [IO.File]::WriteAllLines($f, $baru, $utf8)
    Write-Host "Selesai. Backup: $f.bak2" -ForegroundColor Green
  }
}
php "$root\artisan" view:clear