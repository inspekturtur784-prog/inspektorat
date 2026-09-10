@extends('admin.layout')
@section('title', 'Kelola Tugas & Fungsi')

@section('content')
<div class="admin-header">
    <h1>Kartu Fungsi</h1>
    <a href="{{ route('admin.tugasfungsi.create') }}" class="btn-admin btn-admin-primary">+ Tambah Kartu</a>
</div>

<form class="admin-form" action="{{ route('admin.tugasfungsi.tugaspokok.update') }}" method="POST" style="margin-bottom:28px;">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="tugas_pokok">Tugas Pokok</label>
        <textarea id="tugas_pokok" name="tugas_pokok" style="min-height:100px;">{{ old('tugas_pokok', $tugasPokok ?? '') }}</textarea>
    </div>
    <button type="submit" class="btn-admin btn-admin-primary">Simpan Tugas Pokok</button>
</form>

<hr style="border:none;border-top:1px solid #ECEAE2;margin:0 0 28px;">

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="width: 80px;">Urutan</th>
                <th style="width: 200px;">Judul</th>
                <th>Deskripsi</th>
                <th style="width: 180px;">Ikon</th>
                <th style="width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $item->urutan }}</td>
                    <td><strong>{{ $item->judul }}</strong></td>
                    <td>{{ Str::limit($item->deskripsi, 80) }}</td>
                    <td>{{ \App\Models\TugasFungsi::IKON[$item->icon] ?? $item->icon }}</td>
                    <td class="row-actions">
                        <a href="{{ route('admin.tugasfungsi.edit', $item) }}" class="btn-admin btn-admin-ghost">Edit</a>
                        <form action="{{ route('admin.tugasfungsi.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus kartu ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center; color: #888;">Belum ada kartu Fungsi. Klik "Tambah Kartu" untuk membuat yang pertama.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection.