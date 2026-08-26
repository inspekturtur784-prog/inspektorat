@extends('layouts.app')

@section('title', $struktur->nama . ' — Inspektorat Kota Mojokerto')
@section('meta_description', 'Detail bagian ' . $struktur->nama . ' pada struktur organisasi Inspektorat Kota Mojokerto.')

@section('content')

@include('partials.breadcrumb', [
    'items' => ['Profil' => url('/profil'), 'Struktur Organisasi' => url('/profil#struktur-organisasi')],
    'current' => $struktur->nama,
])

<section style="padding:64px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:760px;">
        <span class="eyebrow">Struktur Organisasi</span>
        <h1 style="font-size:clamp(28px,4vw,40px);margin:16px 0 12px;">{{ $struktur->nama }}</h1>

        @if ($struktur->jabatan_desc)
            <p style="color:var(--slate);font-size:16px;line-height:1.75;margin-bottom:14px;">
                <strong style="color:var(--navy);">Jabatan:</strong> {{ $struktur->jabatan_desc }}
            </p>
        @endif
        @if ($struktur->tugas)
            <p style="color:var(--slate);font-size:16px;line-height:1.75;">
                <strong style="color:var(--navy);">Tugas Bagian:</strong> {{ $struktur->tugas }}
            </p>
        @endif
    </div>
</section>

<section style="padding:56px 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">Pegawai di Bagian Ini</span>
            <h2 style="font-size:22px;">Siapa yang bertugas di {{ $struktur->nama }}</h2>
        </div>

        @if ($pegawaiList->isEmpty())
            <p style="color:var(--slate);">Belum ada pegawai yang terhubung ke bagian ini. Tambahkan lewat halaman Data Pegawai (samakan kolom "Bagian/Unit" dengan "{{ $struktur->bidang_key }}").</p>
        @else
            <div class="struktur-pegawai-list">
                @foreach ($pegawaiList as $pegawai)
                    <a href="{{ route('pegawai.show', $pegawai) }}" class="struktur-pegawai-item">
                        <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->nama }}" class="struktur-pegawai-photo">
                        <div class="struktur-pegawai-info">
                            <span class="pegawai-jabatan">{{ $pegawai->jabatan }}</span>
                            <h3>{{ $pegawai->nama }}</h3>
                            @if ($pegawai->tugas)
                                <p><strong>Tugas:</strong> {{ $pegawai->tugas }}</p>
                            @endif
                            @if ($pegawai->fungsi)
                                <p><strong>Fungsi:</strong> {{ $pegawai->fungsi }}</p>
                            @endif
                        </div>
                        <svg class="struktur-pegawai-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                @endforeach
            </div>
        @endif

        <a href="{{ url('/profil#struktur-organisasi') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin-top:40px;">
            ← Kembali ke Struktur Organisasi
        </a>
    </div>
</section>

@endsection