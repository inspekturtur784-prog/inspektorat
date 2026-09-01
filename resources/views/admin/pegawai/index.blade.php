@extends('admin.layout')
@section('title', 'Kelola Data Pegawai')

@section('content')
<div class="admin-header">
    <h1>Data Pegawai</h1>
    <a href="{{ route('admin.pegawai.create') }}" class="btn-admin btn-admin-primary">+ Tambah Pegawai</a>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px; padding: 10px 15px; background-color: #d4edda; color: #155724; border-radius: 6px;">
        {{ session('success') }}
    </div>
@endif

@if(session('status'))
    <div class="alert alert-success" style="margin-bottom: 20px; padding: 10px 15px; background-color: #d4edda; color: #155724; border-radius: 6px;">
        {{ session('status') }}
    </div>
@endif

<table class="admin-table">
    <thead>
        <tr>
            <th>Urutan</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Bidang</th>
            <th>Golongan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($pegawais as $pegawai)
            <tr>
                <td>{{ $pegawai->urutan }}</td>
                <td>
                    {{-- Deteksi Otomatis Semua Jalur Foto --}}
                    @php
                        $photoName = $pegawai->photo ?? $pegawai->foto;
                        $hasPhotoUrl = !empty($pegawai->photo_url) ? $pegawai->photo_url : (!empty($pegawai->foto_url) ? $pegawai->foto_url : null);
                    @endphp

                    @if ($hasPhotoUrl)
                        <img src="{{ $hasPhotoUrl }}" alt="{{ $pegawai->nama }}" style="width: 45px; height: 55px; object-fit: cover; border-radius: 4px;">
                    @elseif (!empty($photoName) && file_exists(public_path('images/pegawai/' . $photoName)))
                        <img src="{{ asset('images/pegawai/' . $photoName) }}" alt="{{ $pegawai->nama }}" style="width: 45px; height: 55px; object-fit: cover; border-radius: 4px;">
                    @elseif (!empty($photoName) && \Illuminate\Support\Facades\Storage::disk('public')->exists($photoName))
                        <img src="{{ asset('storage/' . $photoName) }}" alt="{{ $pegawai->nama }}" style="width: 45px; height: 55px; object-fit: cover; border-radius: 4px;">
                    @else
                        <span style="color: #999; font-size: 12px;">No Photo</span>
                    @endif
                </td>
                <td>{{ $pegawai->nama }}</td>
                <td>{{ $pegawai->jabatan }}</td>
                <td>{{ $pegawai->bidang ?? '—' }}</td>
                <td>{{ $pegawai->golongan ?? '—' }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.pegawai.destroy', $pegawai) }}" method="POST" onsubmit="return confirm('Hapus data pegawai ini?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Belum ada data pegawai. Klik "Tambah Pegawai" untuk membuat yang pertama.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">
    {{ $pegawais->links() }}
</div>
@endsection