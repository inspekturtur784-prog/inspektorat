$root = "C:\xampp\htdocs\inspektorat"
$f    = "$root\public\css\mengenal-kartu.css"
Copy-Item $f "$f.bak4" -Force

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
  content: "Mengawal anggaran dan program pemerintah kota agar dipakai dengan benar untuk warga.";
  grid-column: 2;
  grid-row: 1;
  display: flex;
  align-items: center;
  min-height: 300px;
  margin-bottom: 44px;
  padding: 40px 44px;
  box-sizing: border-box;
  border-radius: 16px;
  border-left: 5px solid #c9a227;
  color: #fff;
  font-family: "Fraunces", Georgia, "Times New Roman", serif;
  font-size: clamp(22px, 2.4vw, 30px);
  font-weight: 600;
  line-height: 1.4;
  background:
    radial-gradient(circle at 100% 0%, rgba(201,162,39,.22) 0%, transparent 55%),
    linear-gradient(160deg, #0b2545 0%, #071a33 100%);
  box-shadow: 0 18px 40px -20px rgba(11,37,69,.45);
}
@media (max-width: 900px) {
  .ins-about .ins-about-inner { grid-template-columns: 1fr; }
  .ins-about .ins-about-intro { grid-row: 1; }
  .ins-about .ins-about-inner::after { grid-column: 1; grid-row: 2; min-height: 200px; padding: 28px; margin-bottom: 32px; }
  .ins-about .ins-about-grid { grid-row: 3; }
}
'@

[IO.File]::WriteAllText($f, $isi + $blok, (New-Object System.Text.UTF8Encoding($false)))
Write-Host "Selesai. Backup: $f.bak4" -ForegroundColor Green
php "$root\artisan" view:clear