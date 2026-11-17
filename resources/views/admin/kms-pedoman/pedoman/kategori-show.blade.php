@extends('admin.layout')
@section('title', $kategori->nama)

@section('content')
<a href="{{ route('admin.kms.index') }}" class="kp-back">&larr; Kembali ke KMS</a>

<div class="kp-header">
    <h1>{{ $kategori->nama }}</h1>
    <a href="{{ route('admin.pedoman.dokumen.create') }}" class="kp-btn kp-btn-primary">+ Tambah Dokumen</a>
</div>

<div class="kp-card">
    <table class="kp-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th style="width:220px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori->dokumens as $doc)
                <tr>
                    <td>{{ $doc->judul }}</td>
                    <td class="row-actions">
                        <a href="{{ url('/files/' . $doc->file_path) }}" target="_blank" class="kp-btn kp-btn-outline">Lihat</a>
                        <x-btn-edit :href="route('admin.pedoman.dokumen.edit', $doc)" />
                        <x-btn-hapus :action="route('admin.pedoman.dokumen.destroy', $doc)" konfirmasi="Hapus dokumen ini?" />
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="kp-empty">Belum ada dokumen di kategori ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection