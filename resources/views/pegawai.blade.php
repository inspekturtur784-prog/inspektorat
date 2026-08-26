@extends('layouts.app')

@section('title', 'Data Pegawai — Inspektorat Kota Mojokerto')
@section('meta_description', 'Daftar pegawai Inspektorat Kota Mojokerto beserta jabatan, unit kerja, dan tugasnya.')

@section('content')

@include('partials.breadcrumb', ['items' => ['Profil' => url('/profil')], 'current' => 'Data Pegawai'])

<section style="padding:90px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Profil Inspektorat</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Data Pegawai</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Jajaran pegawai yang bertugas di lingkungan Inspektorat Kota Mojokerto.
        </p>
    </div>
</section>

<section style="padding:48px 0 96px;background:var(--paper);">
    <div class="wrap">

        {{-- Pencarian & Filter --}}
        <form method="GET" action="{{ url('/profil/data-pegawai') }}" class="pegawai-toolbar" id="pegawaiSearchForm">
            <div class="pegawai-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="text" name="cari" id="pegawaiSearchInput" value="{{ $cari }}" placeholder="Cari pegawai berdasarkan nama...">
                @if ($bidangAktif)
                    <input type="hidden" name="bidang" value="{{ $bidangAktif }}">
                @endif
            </div>

            <div class="galeri-filter" style="margin:0;">
                <a href="{{ url('/profil/data-pegawai') }}{{ $cari ? '?cari='.$cari : '' }}"
                   class="galeri-tab {{ !$bidangAktif ? 'active' : '' }}">Semua</a>
                @foreach ($bidangList as $bidang)
                    <a href="{{ url('/profil/data-pegawai') }}?bidang={{ urlencode($bidang) }}{{ $cari ? '&cari='.$cari : '' }}"
                       class="galeri-tab {{ $bidangAktif === $bidang ? 'active' : '' }}">{{ $bidang }}</a>
                @endforeach
            </div>
        </form>

        <script>
        (function () {
            var input = document.getElementById('pegawaiSearchInput');
            var form = document.getElementById('pegawaiSearchForm');
            if (!input || !form) return;
            var timer = null;
            input.addEventListener('input', function () {
                clearTimeout(timer);
                timer = setTimeout(function () { form.submit(); }, 500);
            });
        })();
        </script>

        @if ($pegawais->isEmpty())
            <p style="color:var(--slate);margin-top:32px;">Tidak ada pegawai yang cocok dengan pencarian/filter ini.</p>
        @else
            <div class="pegawai-grid">
                @foreach ($pegawais as $pegawai)
                    <a href="{{ route('pegawai.show', $pegawai) }}" class="pegawai-card">
                        <div class="pegawai-photo">
                            <img src="{{ $pegawai->photo_url }}" alt="{{ $pegawai->nama }}">
                        </div>
                        <div class="pegawai-info">
                            <span class="pegawai-jabatan">{{ $pegawai->jabatan }}</span>
                            <h3>{{ $pegawai->nama }}</h3>
                            @if ($pegawai->nip)
                                <p class="pegawai-nip">NIP. {{ $pegawai->nip }}</p>
                            @endif
                            @if ($pegawai->bidang)
                                <span class="pegawai-bidang">{{ $pegawai->bidang }}</span>
                            @endif
                            @if ($pegawai->tugas)
                                <p class="pegawai-tugas-preview">{{ Str::limit($pegawai->tugas, 80) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <a href="{{ url('/profil') }}" class="btn btn-gold" style="background:var(--navy);color:#fff;margin-top:48px;">
            ← Kembali ke Profil
        </a>
    </div>
</section>

@endsection