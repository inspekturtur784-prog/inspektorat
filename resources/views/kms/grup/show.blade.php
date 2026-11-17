@extends('admin.layout')
@section('title', $grup->nama)

@section('content')
<a href="{{ route('admin.kms.subkategori.show', $grup->subkategori_id) }}" class="kp-back">&larr; Kembali ke {{ $grup->subkategori->nama }}</a>

<div class="kp-header">
    <h1>{{ $grup->nama }}</h1>
    <a href="{{ route('admin.kms.dokumen.create', $grup->subkategori) }}?grup={{ $grup->id }}" class="kp-btn kp-btn-primary">+ Tambah Dokumen</a>
</div>

<div class="kp-card">
    <table class="kp-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tipe</th>
                <th>Dilihat</th>
                <th style="width:220px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grup->dokumens as $dokumen)
                <tr>
                    <td>{{ $dokumen->judul }}</td>
                    <td>{{ strtoupper($dokumen->file_type) }}</td>
                    <td>{{ $dokumen->dilihat }}</td>
                    <td class="row-actions">
                        <a href="{{ url('/files/' . $dokumen->file_path) }}" target="_blank" class="kp-btn kp-btn-outline">Lihat</a>
                        <x-btn-edit :href="route('admin.kms.dokumen.edit', $dokumen)" />
                        <x-btn-hapus :action="route('admin.kms.dokumen.destroy', $dokumen)" konfirmasi="Hapus dokumen ini?" />
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="kp-empty">Belum ada dokumen di grup ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection