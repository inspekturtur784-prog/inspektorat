@extends('admin.layout')
@section('title', 'Dashboard')

@section('content')
<div class="admin-header">
    <h1>Dashboard</h1>
</div>

<p style="color:var(--slate);font-size:14.5px;margin:-10px 0 28px;">
    Selamat datang, {{ auth()->user()->name ?? 'Admin' }}. Ini ringkasan konten website Inspektorat saat ini.
</p>

<div class="dash-stats">
    <a href="{{ route('admin.articles.index') }}" class="dash-stat-card">
        <span class="dash-stat-number">{{ $stats['artikel'] }}</span>
        <span class="dash-stat-label">Artikel / Informasi</span>
    </a>
    <a href="{{ route('admin.pegawai.index') }}" class="dash-stat-card">
        <span class="dash-stat-number">{{ $stats['pegawai'] }}</span>
        <span class="dash-stat-label">Data Pegawai</span>
    </a>
    <a href="{{ route('admin.galeri.index') }}" class="dash-stat-card">
        <span class="dash-stat-number">{{ $stats['galeri'] }}</span>
        <span class="dash-stat-label">Foto Galeri</span>
    </a>
    <a href="{{ route('admin.struktur.index') }}" class="dash-stat-card">
        <span class="dash-stat-number">{{ $stats['struktur'] }}</span>
        <span class="dash-stat-label">Bagian Struktur</span>
    </a>
    <a href="{{ route('admin.tugasfungsi.index') }}" class="dash-stat-card">
        <span class="dash-stat-number">{{ $stats['fungsi'] }}</span>
        <span class="dash-stat-label">Kartu Fungsi</span>
    </a>
    <a href="{{ route('admin.pesan.index') }}" class="dash-stat-card">
        <span class="dash-stat-number">{{ $stats['pesan'] }}</span>
        <span class="dash-stat-label">Pesan Belum Dibaca</span>
    </a>
</div>

<div class="admin-header" style="margin-top:40px;">
    <h1 style="font-size:18px;">Kelola Profil</h1>
</div>
<div class="dash-quicklinks">
    <a href="{{ route('admin.pengaturan.edit') }}" class="dash-quicklink">Tentang Inspektorat & Visi Misi</a>
    <a href="{{ route('admin.tugasfungsi.index') }}" class="dash-quicklink">Tugas & Fungsi</a>
    <a href="{{ route('admin.struktur.index') }}" class="dash-quicklink">Struktur Organisasi</a>
    <a href="{{ route('admin.pegawai.index') }}" class="dash-quicklink">Data Pegawai</a>
    <a href="{{ route('admin.galeri.index') }}" class="dash-quicklink">Galeri</a>
    <a href="{{ route('admin.articles.index') }}" class="dash-quicklink">Artikel / Informasi</a>
    <a href="{{ route('admin.pesan.index') }}" class="dash-quicklink">Pesan Masuk</a>
</div>
@endsection