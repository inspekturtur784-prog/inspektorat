@extends('admin.layout')
@section('title', $kategori->nama)

@section('content')
<a href="{{ route('admin.kms.index') }}" class="kp-back">&larr; Kembali ke KMS</a>

<div class="kp-header">
    <h1>{{ $kategori->nama }}</h1>
    <a href="{{ route('admin.kms.subkategori.create', $kategori) }}" class="kp-btn kp-btn-primary">+ Tambah Subkategori</a>
</div>

<div class="kp-card">
    <table class="kp-table">
        <thead>
            <tr>
                <th>Nama Subkategori</th>
                <th>Grup Dokumen</th>
                <th>Dokumen Langsung</th>
                <th style="width:200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori->subkategoris as $sub)
                <tr>
                    <td>{{ $sub->nama }}</td>
                    <td>{{ $sub->grup_dokumens_count }}</td>
                    <td>{{ $sub->dokumens_langsung_count }}</td>
                    <td class="row-actions">
                        <a href="{{ route('admin.kms.subkategori.show', $sub) }}" class="kp-btn kp-btn-outline">Kelola</a>
                        <x-btn-edit :href="route('admin.kms.subkategori.edit', $sub)" />
                        <x-btn-hapus :action="route('admin.kms.subkategori.destroy', $sub)" konfirmasi="Hapus subkategori ini beserta semua isinya?" />
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="kp-empty">Belum ada subkategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection