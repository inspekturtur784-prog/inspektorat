@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $keyword)

@section('content')
<div class="wrap" style="padding: 40px 24px; min-height: 60vh;">
    <h1 style="font-size: 24px; color: #0b2545; margin-bottom: 8px;">Hasil Pencarian untuk: "<strong>{{ $keyword }}</strong>"</h1>
    <p style="color: #5b6b7d; margin-bottom: 32px;">
        Ditemukan {{ $articles->count() + $buletins->count() }} hasil.
    </p>

    {{-- Hasil Berita --}}
    @if($articles->isNotEmpty())
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 18px; color: #0b2545; border-bottom: 2px solid #d4a94a; padding-bottom: 8px; margin-bottom: 16px;">Berita & Artikel ({{ $articles->count() }})</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                @foreach($articles as $item)
                    <div style="border: 1px solid #e4e8ee; border-radius: 8px; padding: 16px; background: #fff;">
                        <h3 style="font-size: 16px; margin: 0 0 8px;">
                            <a href="{{ route('articles.show', $item->slug ?? $item->id) }}" style="color: #0b2545; text-decoration: none; font-weight: 700;">
                                {{ $item->title ?? $item->judul }}
                            </a>
                        </h3>
                        <p style="font-size: 13px; color: #5b6b7d; margin-bottom: 12px;">
                            {{ Str::limit(strip_tags($item->body ?? $item->content ?? $item->isi ?? ''), 100) }}
                        </p>
                        <a href="{{ route('articles.show', $item->slug ?? $item->id) }}" style="color: #d4a94a; font-size: 13px; font-weight: 600; text-decoration: none;">Lihat Selengkapnya &rarr;</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Hasil Buletin --}}
    @if($buletins->isNotEmpty())
        <div style="margin-bottom: 40px;">
            <h2 style="font-size: 18px; color: #0b2545; border-bottom: 2px solid #d4a94a; padding-bottom: 8px; margin-bottom: 16px;">Buletin ({{ $buletins->count() }})</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
                @foreach($buletins as $item)
                    <div style="border: 1px solid #e4e8ee; border-radius: 8px; padding: 16px; background: #fff;">
                        <h3 style="font-size: 16px; margin: 0 0 8px;">
                            <a href="{{ route('buletin.show', $item->slug ?? $item->id) }}" style="color: #0b2545; text-decoration: none; font-weight: 700;">
                                {{ $item->judul }}
                            </a>
                        </h3>
                        <p style="font-size: 13px; color: #5b6b7d; margin-bottom: 12px;">
                            {{ Str::limit(strip_tags($item->deskripsi ?? ''), 100) }}
                        </p>
                        <a href="{{ route('buletin.show', $item->slug ?? $item->id) }}" style="color: #d4a94a; font-size: 13px; font-weight: 600; text-decoration: none;">Lihat Buletin &rarr;</a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Jika Tidak Ada Hasil --}}
    @if($articles->isEmpty() && $buletins->isEmpty())
        <div style="text-align: center; padding: 40px; background: #f7f8fa; border-radius: 8px;">
            <p style="font-size: 16px; color: #5b6b7d; margin: 0;">Tidak ditemukan kata kunci <strong>"{{ $keyword }}"</strong> di seluruh konten.</p>
        </div>
    @endif
</div>
@endsection