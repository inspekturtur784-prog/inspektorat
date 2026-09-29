$root = "C:\xampp\htdocs\inspektorat"
$utf8 = New-Object System.Text.UTF8Encoding($false)

# 1. Partial baru (file baru)
$partial = @'
@php
    $beritaSlider = class_exists('\App\Models\Article')
        ? \App\Models\Article::published()->limit(8)->get()
        : collect();
@endphp

@if ($beritaSlider->isNotEmpty())
<style>
#artikel.ins-berita { display: none; }

.ins-bs-nav { display: flex; gap: 8px; }
.ins-bs-btn { width: 38px; height: 38px; border-radius: 50%; border: 1.5px solid var(--ins-gold, #c9a227); background: transparent; color: #fff; font-size: 22px; line-height: 1; cursor: pointer; transition: background .2s; }
.ins-bs-btn:hover { background: rgba(255,255,255,.12); }

.ins-bs-track { display: flex; gap: 24px; overflow-x: auto; scroll-snap-type: x mandatory; scroll-behavior: smooth; scrollbar-width: none; padding: 8px 2px; }
.ins-bs-track::-webkit-scrollbar { display: none; }

.ins-bs-card { flex: 0 0 calc((100% - 48px) / 3); scroll-snap-align: start; display: block; text-decoration: none; background: #fff; border: 1.5px solid var(--ins-gold, #c9a227); border-radius: 14px; overflow: hidden; transition: transform .2s ease, box-shadow .2s ease; }
.ins-bs-card:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -20px rgba(0,0,0,.5); }
.ins-bs-img { aspect-ratio: 16 / 9; overflow: hidden; }
.ins-bs-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.ins-bs-body { padding: 18px 20px 22px; }
.ins-bs-date { font-size: 13px; color: var(--ins-slate, #5b6b7d); display: block; margin-bottom: 8px; }
.ins-bs-body h3 { font-size: 17px; color: var(--ins-navy, #0b2545); line-height: 1.4; margin: 0 0 12px; font-weight: 700; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.ins-bs-read { font-size: 13.5px; font-weight: 600; color: var(--ins-navy, #0b2545); }

.ins-bs-foot { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-top: 22px; }
.ins-bs-dots { display: flex; gap: 8px; }
.ins-bs-dot { width: 9px; height: 9px; border-radius: 50%; background: rgba(255,255,255,.35); border: 0; padding: 0; cursor: pointer; transition: all .25s; }
.ins-bs-dot.on { width: 24px; border-radius: 6px; background: var(--ins-gold, #c9a227); }
.ins-bs-more { font-size: 13.5px; font-weight: 600; color: #fff; text-decoration: none; }
.ins-bs-more:hover { text-decoration: underline; }
.ins-bs-static .ins-bs-nav, .ins-bs-static .ins-bs-dots { display: none; }

@media (max-width: 900px) { .ins-bs-card { flex-basis: calc((100% - 24px) / 2); } }
@media (max-width: 560px) { .ins-bs-card { flex-basis: 100%; } }
</style>

<section class="ins-berita ins-bs" id="berita-terkini">
  <div class="ins-berita-inner">
    <div class="ins-berita-head">
      <h2>Berita Terkini</h2>
      <div class="ins-berita-rule"></div>
      <div class="ins-bs-nav">
        <button type="button" class="ins-bs-btn" data-bs-prev aria-label="Berita sebelumnya">&#8249;</button>
        <button type="button" class="ins-bs-btn" data-bs-next aria-label="Berita berikutnya">&#8250;</button>
      </div>
    </div>

    <div class="ins-bs-track" data-bs-track>
      @foreach ($beritaSlider as $a)
        <a href="{{ route('articles.show', $a->slug) }}" class="ins-bs-card">
          <div class="ins-bs-img"><img src="{{ $a->cover_url }}" alt="{{ $a->title }}" loading="lazy"></div>
          <div class="ins-bs-body">
            <span class="ins-bs-date">{{ $a->tanggal_indo }}</span>
            <h3>{{ $a->title }}</h3>
            <span class="ins-bs-read">Baca Selengkapnya...</span>
          </div>
        </a>
      @endforeach
    </div>

    <div class="ins-bs-foot">
      <div class="ins-bs-dots" data-bs-dots></div>
      <a href="{{ route('berita.index') }}" class="ins-bs-more">Berita lainnya...</a>
    </div>
  </div>
</section>

<script>
(function () {
  var sec = document.getElementById('berita-terkini');
  if (!sec) return;
  var track = sec.querySelector('[data-bs-track]');
  var dotsBox = sec.querySelector('[data-bs-dots]');
  var prev = sec.querySelector('[data-bs-prev]');
  var next = sec.querySelector('[data-bs-next]');
  var timer = null, paused = false;

  function step() {
    var c = track.querySelector('.ins-bs-card');
    if (!c) return 0;
    var gap = parseFloat(getComputedStyle(track).columnGap) || 24;
    return c.getBoundingClientRect().width + gap;
  }
  function maxIdx() {
    var s = step();
    return s ? Math.max(0, Math.round((track.scrollWidth - track.clientWidth) / s)) : 0;
  }
  function cur() {
    var s = step();
    return s ? Math.round(track.scrollLeft / s) : 0;
  }
  function go(i) {
    var m = maxIdx();
    if (i > m) i = 0;
    if (i < 0) i = m;
    track.scrollTo({ left: i * step(), behavior: 'smooth' });
  }
  function mark() {
    var i = cur(), d = dotsBox.children;
    for (var k = 0; k < d.length; k++) d[k].classList.toggle('on', k === i);
  }
  function buildDots() {
    dotsBox.innerHTML = '';
    var m = maxIdx();
    if (m === 0) { sec.classList.add('ins-bs-static'); return; }
    sec.classList.remove('ins-bs-static');
    for (var i = 0; i <= m; i++) {
      (function (i) {
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'ins-bs-dot';
        b.setAttribute('aria-label', 'Berita ' + (i + 1));
        b.addEventListener('click', function () { go(i); start(); });
        dotsBox.appendChild(b);
      })(i);
    }
    mark();
  }
  function tick() { if (!paused && maxIdx() > 0) go(cur() + 1); }
  function stop() { if (timer) { clearInterval(timer); timer = null; } }
  function start() {
    stop();
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    timer = setInterval(tick, 4500);
  }

  prev.addEventListener('click', function () { go(cur() - 1); start(); });
  next.addEventListener('click', function () { go(cur() + 1); start(); });
  track.addEventListener('scroll', function () { window.requestAnimationFrame(mark); }, { passive: true });
  ['mouseenter', 'focusin', 'touchstart'].forEach(function (e) {
    sec.addEventListener(e, function () { paused = true; }, { passive: true });
  });
  ['mouseleave', 'focusout', 'touchend'].forEach(function (e) {
    sec.addEventListener(e, function () { paused = false; }, { passive: true });
  });
  window.addEventListener('resize', buildDots);
  window.addEventListener('load', buildDots);
  buildDots();
  start();
})();
</script>
@endif
'@
[IO.File]::WriteAllText("$root\resources\views\partials\berita-slider.blade.php", $partial, $utf8)
Write-Host "Partial dibuat." -ForegroundColor Green

# 2. Sisipkan satu baris @include di home.blade.php
$f     = "$root\resources\views\home.blade.php"
$lines = [IO.File]::ReadAllLines($f)

if (($lines -join "`n") -like "*@include('partials.berita-slider')*") {
  Write-Host "Include sudah ada, home.blade.php tidak diubah." -ForegroundColor Yellow
} else {
  $idx = -1
  for ($i = 0; $i -lt $lines.Count; $i++) {
    if ($lines[$i] -match '\{\{--.*BERITA TERKINI.*--\}\}') { $idx = $i; break }
  }
  if ($idx -lt 0) {
    Write-Host "Komentar BERITA TERKINI tidak ditemukan, TIDAK diubah." -ForegroundColor Red
  } else {
    Write-Host "Baris akan disisipkan SEBELUM baris $($idx+1):" -ForegroundColor Cyan
    for ($k = [Math]::Max(0,$idx-3); $k -le [Math]::Min($lines.Count-1,$idx+2); $k++) {
      $t = if ($k -eq $idx) { ">>" } else { "  " }
      Write-Host ("{0} {1,4}: {2}" -f $t, ($k+1), $lines[$k])
    }
    if ((Read-Host "Lanjut? (y/n)") -eq 'y') {
      Copy-Item $f "$f.bak2" -Force
      $baru = New-Object System.Collections.Generic.List[string]
      for ($k = 0; $k -lt $lines.Count; $k++) {
        if ($k -eq $idx) { $baru.Add("@include('partials.berita-slider')"); $baru.Add("") }
        $baru.Add($lines[$k])
      }
      [IO.File]::WriteAllLines($f, $baru, $utf8)
      Write-Host "Selesai. Backup: $f.bak2" -ForegroundColor Green
    } else { Write-Host "Dibatalkan." }
  }
}
php "$root\artisan" view:clear