@extends('layouts.app')

@section('title', 'Berita — Inspektorat Kota Mojokerto')
@section('meta_description', 'Arsip lengkap artikel dan berita seputar kegiatan, pengumuman, dan pengawasan Inspektorat Kota Mojokerto.')

@section('content')

@include('partials.breadcrumb', ['current' => 'Berita'])

<section style="padding:64px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Informasi Terbaru</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Berita</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Arsip lengkap kegiatan, pengumuman, dan berita seputar pengawasan Inspektorat Kota Mojokerto.
        </p>
    </div>
</section>

<section class="articles" style="padding:56px 0 96px;">
    <div class="wrap">
        @if ($articles->isEmpty())
            <p style="color:var(--slate);">Belum ada artikel yang dipublikasikan.</p>
        @else
            <div class="article-grid">
                @foreach ($articles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="article-card">
                        <div class="article-thumb">
                            <img src="{{ $article->cover_url }}" alt="{{ $article->title }}" loading="lazy">
                        </div>
                        <div class="article-body">
                            <span class="eyebrow" style="margin-bottom:0;">{{ $article->category ?? 'Artikel' }}</span>
                            <h3>{{ $article->title }}</h3>
                            <span class="article-date">{{ $article->tanggal_indo }}</span>
                            <span class="article-read">
                                Baca
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div style="margin-top:44px;">{{ $articles->links() }}</div>
        @endif
    </div>
</section>

@endsection