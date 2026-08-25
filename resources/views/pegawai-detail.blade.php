@extends('layouts.app')

@section('title', $pegawai->nama . ' — Inspektorat Kota Mojokerto')
@section('meta_description', $pegawai->jabatan . ' Inspektorat Kota Mojokerto')

@section('content')

@include('partials.breadcrumb', [
    'items' => ['Profil' => url('/profil'), 'Data Pegawai' => url('/profil/data-pegawai')],
    'current' => $pegawai->nama,
])

<section style="padding:64px 0 40px;background:var(--paper);">
    <div class="wrap" style="max-width:720px;">
        <a href="{{ url('/profil/data-pegawai') }}" class="profil-link" style="margin-bottom:20px;display:inline-flex;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="transform:rotate(180deg);"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            Kembali ke Data Pegawai
        </a>
        <span class="eyebrow">Detail Pegawai</span>
    </div>
</section>

<section style="padding:0 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="pegawai-detail">
            <div class="pegawai-detail-photo">
                <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->nama }}">
            </div>

            <div class="pegawai-detail-info">
                <span class="pegawai-jabatan">{{ $pegawai->jabatan }}</span>
                <h1>{{ $pegawai->nama }}</h1>

                <div class="pegawai-detail-meta">
                    @if ($pegawai->bidang)
                        <div><strong>Unit Kerja</strong><span>{{ $pegawai->bidang }}</span></div>
                    @endif
                    @if ($pegawai->golongan)
                        <div><strong>Pangkat / Golongan</strong><span>{{ $pegawai->golongan }}</span></div>
                    @endif
                    @if ($pegawai->nip)
                        <div><strong>NIP</strong><span>{{ $pegawai->nip }}</span></div>
                    @endif
                </div>

                @if ($pegawai->tugas)
                    <div class="pegawai-detail-block">
                        <h3>Tugas</h3>
                        <p>{{ $pegawai->tugas }}</p>
                    </div>
                @endif

                @if ($pegawai->fungsi)
                    <div class="pegawai-detail-block">
                        <h3>Fungsi</h3>
                        <p>{{ $pegawai->fungsi }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection