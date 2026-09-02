@extends('layouts.app')

@section('title', $galeri->judul . ' — Galeri Inspektorat Kota Mojokerto')
@section('meta_description', $galeri->deskripsi)

@section('content')

@include('partials.breadcrumb', [
    'items' => ['Profil' => url('/profil'), 'Galeri' => url('/profil/galeri')],
    'current' => $galeri->judul,
])

<section style="padding:64px 0 40px;">
    <div class="wrap" style="max-width:820px;">
        <span class="eyebrow">{{ $galeri->kategori }}</span>
        <h1 style="font-size:clamp(24px,3.6vw,36px);margin:16px 0 8px;">{{ $galeri->judul }}</h1>
        <p style="color:var(--slate);font-family:'IBM Plex Mono',monospace;font-size:13px;">{{ $galeri->tanggal_indo }}</p>
    </div>
</section>

<div class="wrap" style="max-width:820px;">
    <img src="{{ $galeri->foto_url }}" alt="{{ $galeri->judul }}"
         style="width:100%;border-radius:var(--radius);margin-bottom:28px;">

    @if ($galeri->deskripsi)
        <p style="font-size:16px;color:var(--ink);line-height:1.8;">{{ $galeri->deskripsi }}</p>
    @endif

    <a href="{{ url('/profil/galeri') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin:36px 0 60px;">
        ← Kembali ke Galeri
    </a>
</div>

@if ($related->isNotEmpty())
<section style="background:#fff;border-top:1px solid var(--line);padding-top:56px;padding-bottom:80px;">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Kategori Sama</span>
            <h2 style="font-size:22px;">Foto lain di "{{ $galeri->kategori }}"</h2>
        </div>
        <div class="galeri-grid">
            @foreach ($related as $item)
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
    </div>
</section>
@endif

@endsection