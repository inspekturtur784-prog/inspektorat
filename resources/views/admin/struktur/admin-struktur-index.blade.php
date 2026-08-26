@extends('admin.layout')
@section('title', 'Kelola Struktur Organisasi')

@section('content')
<div class="admin-header">
    <h1>Struktur Organisasi</h1>
    <a href="{{ route('admin.struktur.create') }}" class="btn-admin btn-admin-primary">+ Tambah Bagian</a>
</div>

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
                    <form action="{{ route('admin.struktur.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus bagian ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada bagian struktur organisasi.</td></tr>
        @endforelse
    </tbody>
</table>

<p style="font-size:13px;color:var(--slate);margin-top:16px;">
    "Bidang Key" harus persis sama dengan isi kolom "Bagian/Unit" di halaman Data Pegawai,
    supaya nama pejabat otomatis muncul di bagian ini.
</p>
@endsection