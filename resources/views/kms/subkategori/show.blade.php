@extends('admin.layout')
@section('title', $subkategori->nama)

@section('content')
<a href="{{ route('admin.kms.kategori.show', $subkategori->kategori_id) }}" class="kp-back">&larr; Kembali ke {{ $subkategori->kategori->nama }}</a>

<div class="kp-header">
    <h1>{{ $subkategori->nama }}</h1>
    <a href="{{ route('admin.kms.dokumen.create', $subkategori) }}" class="kp-btn kp-btn-primary">+ Tambah Dokumen</a>
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
            @forelse ($subkategori->dokumensLangsung as $dokumen)
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
                <tr><td colspan="4" class="kp-empty">Belum ada dokumen di subkategori ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($subkategori->grupDokumens->count())
    <p class="kp-subtitle">Grup Dokumen (data lama)</p>
    <div class="kp-card">
        <table class="kp-table">
            <thead>
                <tr>
                    <th>Nama Grup</th>
                    <th>Jumlah Dokumen</th>
                    <th style="width:200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subkategori->grupDokumens as $grup)
                    <tr>
                        <td>{{ $grup->nama }}</td>
                        <td>{{ $grup->dokumens_count }}</td>
                        <td class="row-actions">
                            <a href="{{ route('admin.kms.grup.show', $grup) }}" class="kp-btn kp-btn-outline">Kelola</a>
                            <x-btn-edit :href="route('admin.kms.grup.edit', $grup)" />
                            <x-btn-hapus :action="route('admin.kms.grup.destroy', $grup)" konfirmasi="Hapus grup ini beserta dokumennya?" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection