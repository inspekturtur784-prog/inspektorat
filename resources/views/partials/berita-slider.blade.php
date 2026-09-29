@php
    $bsItems = class_exists('\App\Models\Article')
        ? \App\Models\Article::published()->limit(10)->get()
        : collect();

    $bsData = $bsItems->map(function ($a) {
        return [
            'url'   => route('articles.show', $a->slug),
            'img'   => $a->cover_url,
            'title' => $a->title,
            'date'  => $a->tanggal_indo,
        ];
    })->values();

    $bsFirst = $bsItems->first();
    $bsRest  = $bsItems->slice(1, 5);
@endphp

@if ($bsItems->isNotEmpty())
<style>
#artikel.ins-berita { display: none; }

.ins-bs2 .ins-berita-grid { align-items: stretch; transition: opacity .25s ease; }
.ins-bs2 .ins-berita-grid.is-fading { opacity: 0; }
.ins-bs2 .ins-berita-featured { display: flex; flex-direction: column; }
.ins-bs2 .ins-berita-featured-body { flex: 1; }
.ins-bs2 .ins-berita-featured-body h3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.ins-bs2 .ins-bs2-side { display: flex; flex-direction: column; }
.ins-bs2 .ins-berita-list { flex: 1; gap: 12px; }
.ins-bs2 .ins-berita-item { flex: 1; align-items: center; padding: 10px 12px; }
.ins-bs2 .ins-berita-item-thumb { width: 84px; height: 62px; }
.ins-bs2 .ins-berita-item-body h4 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.ins-bs2 .ins-berita-more { margin-top: 12px; }

.ins-bs-nav { display: flex; gap: 8px; }
.ins-bs-btn { width: 38px; height: 38px; border-radius: 50%; border: 1.5px solid var(--ins-gold, #c9a227); background: transparent; color: #fff; font-size: 22px; line-height: 1; cursor: pointer; transition: background .2s; }
.ins-bs-btn:hover { background: rgba(255,255,255,.12); }
.ins-bs-dots { display: flex; gap: 8px; margin-top: 24px; }
.ins-bs-dot { width: 9px; height: 9px; border-radius: 50%; background: rgba(255,255,255,.35); border: 0; padding: 0; cursor: pointer; transition: all .25s; }
.ins-bs-dot.on { width: 24px; border-radius: 6px; background: var(--ins-gold, #c9a227); }
</style>

<section class="ins-berita ins-bs2" id="berita-terkini">
  <div class="ins-berita-inner">
    <div class="ins-berita-head">
      <h2>Berita Terkini</h2>
      <div class="ins-berita-rule"></div>
      <div class="ins-bs-nav">
        <button type="button" class="ins-bs-btn" data-bs-prev aria-label="Berita sebelumnya">&#8249;</button>
        <button type="button" class="ins-bs-btn" data-bs-next aria-label="Berita berikutnya">&#8250;</button>
      </div>
    </div>

    <div class="ins-berita-grid" data-bs-grid>
      <a href="{{ route('articles.show', $bsFirst->slug) }}" class="ins-berita-featured" data-bs-featured>
        <div class="ins-berita-featured-img">
          <img src="{{ $bsFirst->cover_url }}" alt="{{ $bsFirst->title }}">
        </div>
        <div class="ins-berita-featured-body">
          <span class="ins-berita-date">{{ $bsFirst->tanggal_indo }}</span>
          <h3>{{ $bsFirst->title }}</h3>
          <span class="ins-berita-read">Baca Selengkapnya...</span>
        </div>
      </a>

      <div class="ins-bs2-side">
        <div class="ins-berita-list" data-bs-list>
          @foreach ($bsRest as $a)
            <a href="{{ route('articles.show', $a->slug) }}" class="ins-berita-item">
              <div class="ins-berita-item-thumb"><img src="{{ $a->cover_url }}" alt="{{ $a->title }}"></div>
              <div class="ins-berita-item-body">
                <span class="ins-berita-date">{{ $a->tanggal_indo }}</span>
                <h4>{{ $a->title }}</h4>
                <span class="ins-berita-read">Baca Selengkapnya...</span>
              </div>
            </a>
          @endforeach
        </div>
        <div class="ins-berita-more">
          <a href="{{ route('berita.index') }}">Berita lainnya...</a>
        </div>
      </div>
    </div>

    <div class="ins-bs-dots" data-bs-dots></div>
  </div>
</section>

<script>
(function () {
  var data = @json($bsData);
  var SHOW = 6;
  var sec = document.getElementById('berita-terkini');
  if (!sec) return;

  var grid = sec.querySelector('[data-bs-grid]');
  var featured = sec.querySelector('[data-bs-featured]');
  var list = sec.querySelector('[data-bs-list]');
  var dotsBox = sec.querySelector('[data-bs-dots]');
  var nav = sec.querySelector('.ins-bs-nav');
  var prev = sec.querySelector('[data-bs-prev]');
  var next = sec.querySelector('[data-bs-next]');
  var idx = 0, timer = null, paused = false;

  if (data.length <= SHOW) {
    nav.style.display = 'none';
    dotsBox.style.display = 'none';
    return;
  }

  function el(tag, cls, text) {
    var e = document.createElement(tag);
    if (cls) e.className = cls;
    if (text != null) e.textContent = text;
    return e;
  }

  function render() {
    var f = data[idx];
    featured.href = f.url;
    var fi = featured.querySelector('img');
    fi.src = f.img;
    fi.alt = f.title;
    featured.querySelector('.ins-berita-date').textContent = f.date;
    featured.querySelector('h3').textContent = f.title;

    list.innerHTML = '';
    for (var k = 1; k < SHOW; k++) {
      var d = data[(idx + k) % data.length];
      var a = el('a', 'ins-berita-item');
      a.href = d.url;
      var th = el('div', 'ins-berita-item-thumb');
      var im = document.createElement('img');
      im.src = d.img;
      im.alt = d.title;
      th.appendChild(im);
      var body = el('div', 'ins-berita-item-body');
      body.appendChild(el('span', 'ins-berita-date', d.date));
      body.appendChild(el('h4', null, d.title));
      body.appendChild(el('span', 'ins-berita-read', 'Baca Selengkapnya...'));
      a.appendChild(th);
      a.appendChild(body);
      list.appendChild(a);
    }

    var dots = dotsBox.children;
    for (var j = 0; j < dots.length; j++) dots[j].classList.toggle('on', j === idx);
  }

  function show(i) {
    idx = (i + data.length) % data.length;
    grid.classList.add('is-fading');
    setTimeout(function () {
      render();
      grid.classList.remove('is-fading');
    }, 250);
  }

  function stop() { if (timer) { clearInterval(timer); timer = null; } }
  function start() {
    stop();
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    timer = setInterval(function () { if (!paused) show(idx + 1); }, 6000);
  }

  for (var i = 0; i < data.length; i++) {
    (function (i) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 'ins-bs-dot';
      b.setAttribute('aria-label', 'Berita ' + (i + 1));
      b.addEventListener('click', function () { show(i); start(); });
      dotsBox.appendChild(b);
    })(i);
  }

  prev.addEventListener('click', function () { show(idx - 1); start(); });
  next.addEventListener('click', function () { show(idx + 1); start(); });
  ['mouseenter', 'focusin', 'touchstart'].forEach(function (e) {
    sec.addEventListener(e, function () { paused = true; }, { passive: true });
  });
  ['mouseleave', 'focusout', 'touchend'].forEach(function (e) {
    sec.addEventListener(e, function () { paused = false; }, { passive: true });
  });

  render();
  start();
})();
</script>
@endif