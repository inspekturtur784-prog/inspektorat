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
            <p>
                Inspektorat adalah unsur pengawas penyelenggaraan pemerintahan daerah,
                yang bekerja langsung di bawah dan bertanggung jawab kepada Wali Kota.
                Kami hadir untuk memastikan setiap kebijakan, program, dan penggunaan
                anggaran daerah berjalan sesuai aturan — demi Kota Mojokerto yang
                bersih, akuntabel, dan terpercaya.
            </p>
        </div>

        <div class="definition-list" style="grid-template-columns:repeat(4,1fr);">
            <div class="def-card">
                <span class="seal-mark">K</span>
                <h3>Kedudukan</h3>
                <p>Berkedudukan sebagai unsur pengawas penyelenggaraan pemerintahan daerah, di bawah dan bertanggung jawab langsung kepada Wali Kota.</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">P</span>
                <h3>Peran</h3>
                <p>Menjadi mitra strategis seluruh perangkat daerah dalam mewujudkan tata kelola pemerintahan yang taat aturan dan berintegritas.</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">T</span>
                <h3>Tujuan</h3>
                <p>Mewujudkan penyelenggaraan pemerintahan Kota Mojokerto yang bersih, akuntabel, dan bebas dari korupsi.</p>
            </div>
            <div class="def-card">
                <span class="seal-mark">F</span>
                <h3>Fungsi</h3>
                <p>Melaksanakan audit, reviu, evaluasi, pemantauan, dan bentuk pengawasan lain sesuai kebijakan Wali Kota.</p>
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
                <p class="visi-text">
                    "Terwujudnya pengawasan yang profesional untuk mendukung
                    tata kelola pemerintahan Kota Mojokerto yang bersih,
                    akuntabel, dan berintegritas."
                </p>
            </div>

            <div class="misi-card">
                <span class="vm-label">Misi</span>
                <ol class="misi-list">
                    <li>Meningkatkan kualitas dan profesionalisme aparatur pengawasan internal pemerintah.</li>
                    <li>Mendorong penyelenggaraan pemerintahan daerah yang taat aturan dan bebas dari korupsi, kolusi, dan nepotisme.</li>
                    <li>Memperkuat sistem pengendalian intern pada seluruh perangkat daerah.</li>
                    <li>Membangun budaya integritas dan zona bebas gratifikasi di lingkungan pemerintah kota.</li>
                </ol>
            </div>
        </div>
    </div>
</section>

{{-- ============ NAVIGASI BAGIAN LAIN (menyusul) ============ --}}
<section style="padding:64px 0 96px;background:var(--paper);">
    <div class="wrap">
        <div class="section-head" style="margin-bottom:32px;">
            <span class="eyebrow">Bagian Lainnya</span>
            <h2 style="font-size:24px;">Jelajahi profil lebih lanjut</h2>
        </div>

        <div class="profil-grid">
            <a href="{{ url('/profil/peta-jabatan') }}" class="profil-card">
                <div class="profil-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="6" r="3"/><path d="M12 9v4"/>
                        <circle cx="6" cy="17" r="2.6"/><circle cx="12" cy="17" r="2.6"/><circle cx="18" cy="17" r="2.6"/>
                        <path d="M8.3 15.3L10.5 13M15.7 15.3L13.5 13"/>
                    </svg>
                </div>
                <h3>Peta Jabatan</h3>
                <p>Struktur organisasi dan susunan jabatan di lingkungan Inspektorat.</p>
                <span class="profil-link">Lihat Bagian Ini
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </span>
            </a>

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
        </div>
    </div>
</section>

@endsection