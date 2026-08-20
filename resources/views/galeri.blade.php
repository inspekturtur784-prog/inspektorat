@extends('layouts.app')

@section('title', 'Galeri — Inspektorat Kota Mojokerto')
@section('meta_description', 'Galeri foto kegiatan, dokumentasi, pengawasan, dan sosialisasi Inspektorat Kota Mojokerto.')

@section('content')

<section style="padding:90px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">F. Galeri</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Galeri Foto</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Dokumentasi kegiatan, pengawasan, dan sosialisasi Inspektorat Kota Mojokerto.
        </p>
    </div>
</section>

<section style="padding:48px 0 96px;background:var(--paper);">
    <div class="wrap">

        {{-- Filter kategori --}}
        <div class="galeri-filter">
            <a href="{{ url('/profil/galeri') }}" class="galeri-tab {{ !$kategoriAktif ? 'active' : '' }}">Semua</a>
            @foreach ($kategoriList as $kat)
                <a href="{{ url('/profil/galeri') }}?kategori={{ $kat }}"
                   class="galeri-tab {{ $kategoriAktif === $kat ? 'active' : '' }}">{{ $kat }}</a>
            @endforeach
        </div>

        @if ($items->isEmpty())
            <p style="color:var(--slate);margin-top:32px;">Belum ada foto untuk kategori ini.</p>
        @else
            <div class="galeri-grid">
                @foreach ($items as $item)
                    <a href="{{ route('galeri.show', $item->slug) }}" class="galeri-card">
                        <div class="galeri-thumb">
                            <img src="{{ $item->foto_url }}" alt="{{ $item->judul }}" loading="lazy">
                            <span class="galeri-kategori">{{ $item->kategori }}</span>
                        </div>
                        <div class="galeri-caption">
                            <h3>{{ $item->judul }}</h3>
                            <span class="galeri-date">{{ $item->tanggal_indo }}</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div style="margin-top:40px;">{{ $items->links() }}</div>
        @endif

        <a href="{{ url('/profil') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin-top:24px;">
            ← Kembali ke Profil
        </a>
    </div>
</section>

@endsection