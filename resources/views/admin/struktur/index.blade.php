@extends('admin.layout')
@section('title', 'Kelola Struktur Organisasi')

@section('content')
<div class="admin-header">
    <h1>Struktur Organisasi</h1>
    <a href="{{ route('admin.struktur.create') }}" class="btn-admin btn-admin-primary">+ Tambah Bagian</a>
</div>

{{-- Pesan Notifikasi Sukses --}}
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
            <th>Nama Bagian</th>
            <th>Puncak Bagan?</th>
            <th>Bidang Key (link ke Data Pegawai)</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr>
                <td>{{ $item->urutan }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    @if ($item->is_top)
                        <span class="badge badge-on">Ya</span>
                    @else
                        <span class="badge badge-off">Tidak</span>
                    @endif
                </td>
                <td>{{ $item->bidang_key ?? '—' }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.struktur.edit', $item) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.struktur.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus bagian ini?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada bagian struktur organisasi. Klik "+ Tambah Bagian" untuk menambahkan.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<p style="font-size:13px; color:var(--slate, #666); margin-top:16px;">
    "Bidang Key" harus persis sama dengan isi kolom "Bagian/Unit" di halaman Data Pegawai,
    supaya nama pejabat otomatis muncul di bagian ini.
</p>
@endsection