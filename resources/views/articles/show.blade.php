@extends('layouts.app')

@section('title', $article->title . ' — Inspektorat Kota Mojokerto')
@section('meta_description', $article->excerpt)

@section('content')
@include('partials.breadcrumb', ['current' => $article->title])
<section style="padding:64px 0 40px;">
    <div class="wrap" style="max-width:760px;">
        <span class="eyebrow">{{ $article->category ?? 'Artikel' }}</span>
        <h1 style="font-size:clamp(26px,4vw,40px);margin:16px 0 10px;">{{ $article->title }}</h1>
        <p style="color:var(--slate);font-family:'IBM Plex Mono',monospace;font-size:13px;">{{ $article->tanggal_indo }}</p>
    </div>
</section>

<div class="wrap" style="max-width:760px;">
    <img src="{{ $article->cover_url }}" alt="{{ $article->title }}"
         style="width:100%;border-radius:var(--radius);margin-bottom:34px;">

    <div style="font-size:16.5px;color:var(--ink);line-height:1.8;">
        {!! nl2br(e($article->body)) !!}
    </div>

    <a href="{{ url('/') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin:40px 0 60px;">
        ← Kembali ke Beranda
    </a>
</div>

@if ($related->isNotEmpty())
<section style="background:#fff;border-top:1px solid var(--line);padding-top:60px;">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Baca Juga</span>
            <h2 style="font-size:24px;">Artikel lainnya</h2>
        </div>
        <div class="article-grid">
            @foreach ($related as $item)
                <a href="{{ route('articles.show', $item->slug) }}" class="article-card">
                    <div class="article-thumb">
                        <img src="{{ $item->cover_url }}" alt="{{ $item->title }}">
                    </div>
                    <div class="article-body">
                        <h3>{{ $item->title }}</h3>
                        <span class="article-date">{{ $item->tanggal_indo }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection