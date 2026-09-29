$root = "C:\xampp\htdocs\inspektorat"
$f    = "$root\public\css\mengenal-kartu.css"
Copy-Item $f "$f.bak5" -Force

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
  content: "KOMITMEN KAMI\A Menjaga Integritas, Mengawal Tata Kelola Pemerintahan";
  white-space: pre-line;
  grid-column: 2;
  grid-row: 1;
  display: block;
  min-height: 300px;
  margin-bottom: 44px;
  padding: 72px 44px 40px;
  box-sizing: border-box;
  border: 1px solid #d9e2ef;
  border-radius: 12px;
  color: #0b2545;
  font-family: "Fraunces", Georgia, "Times New Roman", serif;
  font-size: clamp(20px, 2vw, 26px);
  font-weight: 600;
  line-height: 1.5;
  background-color: #f5f7fb;
  background-image: linear-gradient(#c9a227, #c9a227);
  background-repeat: no-repeat;
  background-position: 44px 40px;
  background-size: 48px 3px;
}
.ins-about .ins-about-inner::after::first-line {
  color: #8a6d12;
  font-family: inherit;
  font-size: 13px;
  font-weight: 700;
  letter-spacing: .14em;
}
@media (max-width: 900px) {
  .ins-about .ins-about-inner { grid-template-columns: 1fr; }
  .ins-about .ins-about-intro { grid-row: 1; }
  .ins-about .ins-about-inner::after { grid-column: 1; grid-row: 2; min-height: 0; padding: 64px 28px 28px; margin-bottom: 32px; background-position: 28px 32px; }
  .ins-about .ins-about-grid { grid-row: 3; }
}
'@

[IO.File]::WriteAllText($f, $isi + $blok, (New-Object System.Text.UTF8Encoding($false)))
Write-Host "Selesai. Backup: $f.bak5" -ForegroundColor Green
php "$root\artisan" view:clear