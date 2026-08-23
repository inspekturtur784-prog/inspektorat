@extends('layouts.app')

@section('title', 'Galeri — Inspektorat Kota Mojokerto')
@section('meta_description', 'Galeri foto kegiatan, dokumentasi, pengawasan, dan sosialisasi Inspektorat Kota Mojokerto.')

@section('content')

<section style="padding:90px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">F. Galeri</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Galeri Foto</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Dokumentasi kegiatan, pengawasan, dan sosialisasi Inspektorat Kota Mojokerto. Klik foto untuk melihat lebih besar.
        </p>
    </div>
</section>

<section style="padding:48px 0 96px;background:var(--paper);">
    <div class="wrap">

        {{-- Filter kategori --}}
        <div class="galeri-filter">
            <a href="{{ url('/profil/galeri') }}" class="galeri-tab {{ !$kategoriAktif ? 'active' : '' }}">Semua</a>
            @foreach ($kategoriList as $kat)
                <a href="{{ url('/profil/galeri') }}?kategori={{ urlencode($kat) }}"
                   class="galeri-tab {{ $kategoriAktif === $kat ? 'active' : '' }}">{{ $kat }}</a>
            @endforeach
        </div>

        @if ($items->isEmpty())
            <p style="color:var(--slate);margin-top:32px;">Belum ada foto untuk kategori ini.</p>
        @else
            <div class="galeri-grid">
                @foreach ($items as $item)
                    <button type="button" class="galeri-card galeri-trigger"
                        data-img="{{ $item->foto_url }}"
                        data-judul="{{ $item->judul }}"
                        data-tanggal="{{ $item->tanggal_indo }}"
                        data-kategori="{{ $item->kategori }}"
                        data-deskripsi="{{ $item->deskripsi }}"
                        data-link="{{ route('galeri.show', $item->slug) }}">
                        <span class="galeri-thumb">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" loading="lazy">
                            <span class="galeri-kategori">{{ $item->kategori }}</span>
                        </span>
                        <span class="galeri-caption">
                            <span class="galeri-caption-title">{{ $item->judul }}</span>
                            <span class="galeri-date">{{ $item->tanggal_indo }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        @endif

        <a href="{{ url('/profil') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin-top:40px;">
            ← Kembali ke Profil
        </a>
    </div>
</section>

{{-- ============ LIGHTBOX ============ --}}
<div class="lightbox" id="galeriLightbox" aria-hidden="true">
    <div class="lightbox-backdrop" data-close></div>
    <div class="lightbox-panel" role="dialog" aria-modal="true" aria-label="Detail foto galeri">
        <button type="button" class="lightbox-close" data-close aria-label="Tutup">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </button>
        <div class="lightbox-image">
            <img id="lightboxImg" src="" alt="">
        </div>
        <div class="lightbox-info">
            <span class="eyebrow" id="lightboxKategori" style="margin-bottom:0;"></span>
            <h3 id="lightboxJudul"></h3>
            <span class="galeri-date" id="lightboxTanggal"></span>
            <p id="lightboxDeskripsi"></p>
            <a href="#" id="lightboxLink" class="profil-link">
                Buka halaman lengkap
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</div>

<script>
(function () {
    const lightbox = document.getElementById('galeriLightbox');
    const img = document.getElementById('lightboxImg');
    const judul = document.getElementById('lightboxJudul');
    const tanggal = document.getElementById('lightboxTanggal');
    const kategori = document.getElementById('lightboxKategori');
    const deskripsi = document.getElementById('lightboxDeskripsi');
    const link = document.getElementById('lightboxLink');

    function openLightbox(data) {
        img.src = data.img;
        img.alt = data.judul;
        judul.textContent = data.judul;
        tanggal.textContent = data.tanggal;
        kategori.textContent = data.kategori;
        deskripsi.textContent = data.deskripsi || '';
        deskripsi.style.display = data.deskripsi ? 'block' : 'none';
        link.href = data.link;

        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.galeri-trigger').forEach(function (card) {
        card.addEventListener('click', function () {
            openLightbox({
                img: card.dataset.img,
                judul: card.dataset.judul,
                tanggal: card.dataset.tanggal,
                kategori: card.dataset.kategori,
                deskripsi: card.dataset.deskripsi,
                link: card.dataset.link,
            });
        });
    });

    lightbox.querySelectorAll('[data-close]').forEach(function (el) {
        el.addEventListener('click', closeLightbox);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) closeLightbox();
    });
})();
</script>

@endsection