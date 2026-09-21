@extends('admin.layout')

@section('title', $kategori->nama)

@section('content')
<p><a href="{{ route('admin.kms.index') }}">&larr; Kembali ke KMS &amp; Pedoman</a></p>

<div class="admin-header"><h1>{{ $kategori->nama }}</h1></div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori->dokumens as $doc)
                <tr>
                    <td>{{ $doc->judul }}</td>
                    <td class="row-actions">
                        <a href="{{ url('/files/' . $doc->file_path) }}" target="_blank" class="btn-admin btn-admin-ghost">Lihat</a>
                        <a href="{{ route('admin.pedoman.dokumen.edit', $doc) }}" class="btn-admin btn-admin-ghost">Edit</a>
                        <form action="{{ route('admin.pedoman.dokumen.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2">Belum ada dokumen di kategori ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection