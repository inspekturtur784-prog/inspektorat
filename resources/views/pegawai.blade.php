@extends('layouts.app')

@section('title', 'Data Pegawai — Inspektorat Kota Mojokerto')
@section('meta_description', 'Daftar pegawai Inspektorat Kota Mojokerto beserta jabatan dan pangkat/golongan.')

@section('content')

<section style="padding:90px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Profil Inspektorat</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Data Pegawai</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Jajaran pegawai yang bertugas di lingkungan Inspektorat Kota Mojokerto.
        </p>
    </div>
</section>

<section style="padding:64px 0 96px;background:var(--paper);">
    <div class="wrap">
        @if ($pegawais->isEmpty())
            <p style="color:var(--slate);">Data pegawai belum tersedia. Tambahkan lewat panel Admin.</p>
        @else
            <div class="pegawai-grid">
                @foreach ($pegawais as $pegawai)
                    <div class="pegawai-card">
                        <div class="pegawai-photo">
                            <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->nama }}">
                        </div>
                        <div class="pegawai-info">
                            <span class="pegawai-jabatan">{{ $pegawai->jabatan }}</span>
                            <h3>{{ $pegawai->nama }}</h3>
                            @if ($pegawai->golongan)
                                <p class="pegawai-golongan">{{ $pegawai->golongan }}</p>
                            @endif
                            @if ($pegawai->bidang)
                                <span class="pegawai-bidang">{{ $pegawai->bidang }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <a href="{{ url('/profil') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin-top:48px;">
            ← Kembali ke Profil
        </a>
    </div>
</section>

@endsection