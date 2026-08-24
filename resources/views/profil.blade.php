@extends('layouts.app')

@section('title', 'Profil Inspektorat — Inspektorat Kota Mojokerto')
@section('meta_description', 'Profil Inspektorat Kota Mojokerto: tentang Inspektorat, kedudukan, peran, tujuan, fungsi, serta visi dan misi.')

@section('content')

{{-- ============ HEADER HALAMAN ============ --}}
<section style="padding:90px 0 30px;background:var(--paper);border-bottom:1px solid var(--line);">
    <div class="wrap" style="max-width:720px;">
        <span class="eyebrow">Tentang Kami</span>
        <h1 style="font-size:clamp(28px,4vw,42px);margin:16px 0 16px;">Profil Inspektorat</h1>
        <p style="color:var(--slate);font-size:16.5px;">
            Kenali lebih jauh Inspektorat Kota Mojokerto — mulai dari kedudukan,
            peran, tujuan, fungsi, hingga visi dan misi yang kami jalankan.
        </p>
    </div>
</section>

{{-- ============ A. TENTANG INSPEKTORAT ============ --}}
<section style="padding:72px 0;background:var(--paper);" id="tentang">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">A. Tentang Inspektorat</span>
            <h2 style="font-size:clamp(24px,3vw,32px);">Apa itu Inspektorat?</h2>
            <p>{{ $p['tentang_intro'] ?? '' }}</p>
        </div>

        <div class="definition-list" style="grid-template-columns:repeat(4,1fr);">
            <div class="def-card">
                <span class="seal-mark">K</span>
                <h3>Kedudukan</h3>
                <p>{{ $p['kedudukan'] ?? '' }}</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">P</span>
                <h3>Peran</h3>
                <p>{{ $p['peran'] ?? '' }}</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">T</span>
                <h3>Tujuan</h3>
                <p>{{ $p['tujuan'] ?? '' }}</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">F</span>
                <h3>Fungsi</h3>
                <p>{{ $p['fungsi_singkat'] ?? '' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ============ B. VISI & MISI ============ --}}
<section class="visimisi" id="visi-misi">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">B. Visi & Misi</span>
            <h2>Arah yang kami tuju</h2>
            <p>Landasan kerja Inspektorat Kota Mojokerto dalam menjalankan tugas pengawasan.</p>
        </div>

        <div class="visimisi-grid">
            <div class="visi-card">
                <span class="vm-label">Visi</span>
                <p class="visi-text">"{{ $p['visi'] ?? '' }}"</p>
            </div>

            <div class="misi-card">
                <span class="vm-label">Misi</span>
                <ol class="misi-list">
                    @foreach ($misiList as $misi)
                        @if (trim($misi) !== '')
                            <li>{{ $misi }}</li>
                        @endif
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>

{{-- ============ C. TUGAS & FUNGSI ============ --}}
<section style="padding:88px 0;background:var(--paper);border-top:1px solid var(--line);" id="tugas-fungsi">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">C. Tugas & Fungsi</span>
            <h2>Apa yang kami kerjakan</h2>
            <p>Penjabaran tugas pokok dan fungsi yang dijalankan Inspektorat.</p>
        </div>

        <div class="tf-tugas-pokok">
            <span class="vm-label" style="color:var(--gold);border-color:var(--line);">Tugas Pokok</span>
            <p style="color:var(--slate);font-size:15.5px;line-height:1.75;max-width:70ch;">
                {{ $p['tugas_pokok'] ?? '' }}
            </p>
        </div>

        <div class="section-head" style="margin-top:48px;margin-bottom:28px;">
            <span class="eyebrow">Fungsi</span>
            <h2 style="font-size:22px;">Fungsi utama kami</h2>
        </div>

        @if ($tugasFungsiList->isEmpty())
            <p style="color:var(--slate);">Belum ada kartu Fungsi. Tambahkan lewat panel Admin.</p>
        @else
            <div class="fungsi-grid">
                @foreach ($tugasFungsiList as $item)
                    <div class="fungsi-card">
                        <div class="fungsi-icon">
                            @include('partials.icon', ['key' => $item->icon])
                        </div>
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ $item->deskripsi }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ============ D. STRUKTUR ORGANISASI ============ --}}
<section class="struktur" id="struktur-organisasi">
    <div class="wrap">
        <div class="section-head">
            <span class="eyebrow">D. Struktur Organisasi</span>
            <h2>Susunan organisasi Inspektorat</h2>
            <p>Klik salah satu bagian untuk melihat detail tugasnya — bukan sekadar bagan gambar.</p>
        </div>

        @php
            $top = $strukturList->firstWhere('is_top', true);
            $branch = $strukturList->where('is_top', false);
        @endphp

        @if ($strukturList->isEmpty())
            <p style="color:#B9C2CC;">Belum ada bagian struktur organisasi. Tambahkan lewat panel Admin.</p>
        @else
            {{-- Bagan visual sederhana --}}
            <div class="org-chart">
                @if ($top)
                    <div class="org-node org-top">{{ $top->nama }}</div>
                @endif
                <div class="org-branch">
                    @foreach ($branch as $b)
                        <div class="org-node">{{ $b->nama }}</div>
                    @endforeach
                </div>
            </div>

            {{-- Detail tiap unit — accordion, bisa diklik --}}
            <div class="org-accordion">
                @foreach ($strukturList as $index => $bagian)
                    <details class="org-item" {{ $index === 0 ? 'open' : '' }}>
                        <summary>
                            <span class="org-item-title">{{ $bagian->nama }}</span>
                            <span class="org-item-toggle">+</span>
                        </summary>
                        <div class="org-item-body">
                            <div class="org-pejabat">
                                <strong>Pejabat:</strong>
                                @forelse ($bagian->pejabat as $pjb)
                                    <span class="org-pejabat-chip">{{ $pjb->nama }} — {{ $pjb->jabatan }}</span>
                                @empty
                                    <span class="org-pejabat-empty">Belum ada data, tambahkan di Data Pegawai.</span>
                                @endforelse
                            </div>
                            @if ($bagian->jabatan_desc)
                                <p><strong>Jabatan:</strong> {{ $bagian->jabatan_desc }}</p>
                            @endif
                            @if ($bagian->tugas)
                                <p><strong>Tugas:</strong> {{ $bagian->tugas }}</p>
                            @endif
                        </div>
                    </details>
                @endforeach
            </div>
        @endif

        <p style="color:#B9C2CC;font-size:13px;margin-top:24px;">
            Data pejabat di atas tersinkron otomatis dengan halaman <a href="{{ url('/profil/data-pegawai') }}" style="color:var(--gold-soft);text-decoration:underline;">Data Pegawai</a>.
        </p>
    </div>
</section>

{{-- ============ NAVIGASI BAGIAN LAIN ============ --}}
<section style="padding:64px 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="section-head" style="margin-bottom:32px;">
            <span class="eyebrow">Bagian Lainnya</span>
            <h2 style="font-size:24px;">Jelajahi profil lebih lanjut</h2>
        </div>

        <div class="profil-grid" style="grid-template-columns:1fr 1fr;max-width:780px;">
            <a href="{{ url('/profil/data-pegawai') }}" class="profil-card">
                <div class="profil-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3>Data Pegawai</h3>
                <p>Daftar pegawai yang bertugas di lingkungan Inspektorat Kota Mojokerto.</p>
                <span class="profil-link">Lihat Bagian Ini
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
            </a>

            <a href="{{ url('/profil/galeri') }}" class="profil-card">
                <div class="profil-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="M21 15l-5-5L5 21"/>
                    </svg>
                </div>
                <h3>Galeri</h3>
                <p>Dokumentasi foto kegiatan, pengawasan, dan sosialisasi Inspektorat.</p>
                <span class="profil-link">Lihat Bagian Ini
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
            </a>
        </div>
    </div>
</section>

@endsection