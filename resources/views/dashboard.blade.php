@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <h1>Dashboard</h1>
</div>

<p class="admin-subtitle">
    Selamat datang, {{ auth()->user()->name ?? 'Admin' }}. Ini ringkasan konten website Inspektorat saat ini.
</p>

<div class="dash-stats">
    <a href="{{ route('admin.articles.index') }}" class="dash-stat-card">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 5a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5Z"/><path d="M14 3v5h5"/><path d="M8 13h8M8 17h5"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['artikel'] }}</span>
            <span class="dash-stat-label">Artikel / Informasi</span>
        </span>
    </a>
    <a href="{{ route('admin.pegawai.index') }}" class="dash-stat-card">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M5 20c0-3.87 3.13-6 7-6s7 2.13 7 6"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['pegawai'] }}</span>
            <span class="dash-stat-label">Data Pegawai</span>
        </span>
    </a>
    <a href="{{ route('admin.galeri.index') }}" class="dash-stat-card">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="15" rx="2"/><circle cx="8.5" cy="10" r="1.8"/><path d="M21 16.5 15.5 12 5 19"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['galeri'] }}</span>
            <span class="dash-stat-label">Foto Galeri</span>
        </span>
    </a>
    <a href="{{ route('admin.struktur.index') }}" class="dash-stat-card">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="9" y="3" width="6" height="5" rx="1"/><rect x="3" y="16" width="6" height="5" rx="1"/><rect x="15" y="16" width="6" height="5" rx="1"/><path d="M12 8v5M6 16v-3h12v3"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['struktur'] }}</span>
            <span class="dash-stat-label">Bagian Struktur</span>
        </span>
    </a>
    <a href="{{ route('admin.tugasfungsi.index') }}" class="dash-stat-card">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 11.5 11 13.5 15.5 9"/><path d="M4 6a2 2 0 0 1 2-2h9l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6Z"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['fungsi'] }}</span>
            <span class="dash-stat-label">Kartu Fungsi</span>
        </span>
    </a>
    <a href="{{ route('admin.pesan.index') }}" class="dash-stat-card {{ $stats['pesan'] > 0 ? 'dash-stat-card-alert' : '' }}">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4V6Z"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['pesan'] }}</span>
            <span class="dash-stat-label">Pesan Belum Dibaca</span>
        </span>
    </a>
    <a href="{{ route('admin.buletin.index') }}" class="dash-stat-card">
        <span class="dash-stat-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 3h9l4 4v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/><path d="M8 9h7M8 13h7M8 17h4"/></svg>
        </span>
        <span class="dash-stat-body">
            <span class="dash-stat-number">{{ $stats['buletin'] }}</span>
            <span class="dash-stat-label">Buletin</span>
        </span>
    </a>
</div>

<div class="admin-header" style="margin-top:44px;">
    <h1 class="admin-header-sub">Kelola Profil</h1>
</div>
<div class="dash-quicklinks">
    <a href="{{ route('admin.pengaturan.edit') }}" class="dash-quicklink">Tentang Inspektorat &amp; Visi Misi</a>
    <a href="{{ route('admin.tugasfungsi.index') }}" class="dash-quicklink">Tugas &amp; Fungsi</a>
    <a href="{{ route('admin.struktur.index') }}" class="dash-quicklink">Struktur Organisasi</a>
    <a href="{{ route('admin.pegawai.index') }}" class="dash-quicklink">Data Pegawai</a>
    <a href="{{ route('admin.galeri.index') }}" class="dash-quicklink">Galeri</a>
    <a href="{{ route('admin.articles.index') }}" class="dash-quicklink">Artikel / Informasi</a>
    <a href="{{ route('admin.pesan.index') }}" class="dash-quicklink">Pesan Masuk</a>
    <a href="{{ route('admin.buletin.index') }}" class="dash-quicklink">Buletin</a>
</div>
@endsection
