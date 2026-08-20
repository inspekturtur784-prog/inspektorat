@extends('admin.layout')
@section('title', 'Kelola Data Pegawai')

@section('content')
<div class="admin-header">
    <h1>Data Pegawai</h1>
    <a href="{{ route('admin.pegawai.create') }}" class="btn-admin btn-admin-primary">+ Tambah Pegawai</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Urutan</th>
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
                <td>{{ $pegawai->nama }}</td>
                <td>{{ $pegawai->jabatan }}</td>
                <td>{{ $pegawai->bidang ?? '—' }}</td>
                <td>{{ $pegawai->golongan ?? '—' }}</td>
                <td class="row-actions">
                    <a href="{{ route('admin.pegawai.edit', $pegawai) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.pegawai.destroy', $pegawai) }}" method="POST" onsubmit="return confirm('Hapus data pegawai ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada data pegawai. Klik "Tambah Pegawai" untuk membuat yang pertama.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $pegawais->links() }}</div>
@endsection