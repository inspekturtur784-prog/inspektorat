@extends('layouts.admin')

@section('content')
<a href="{{ route('admin.kms.index') }}">&larr; Kembali ke daftar kategori</a>

<div class="d-flex justify-content-between align-items-center mt-2 mb-3">
    <h4 class="fw-bold">{{ $category->name }}</h4>
    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalTambahDokumen">
        + Tambah Dokumen
    </button>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-hover bg-white">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Tag</th>
            <th>Tipe File</th>
            <th>Dilihat</th>
            <th style="width: 220px;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($documents as $doc)
            <tr>
                <td>{{ $doc->title }}</td>
                <td>{{ $doc->tag ?: '-' }}</td>
                <td>{{ $doc->file_type }}</td>
                <td>{{ $doc->views }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditDokumen{{ $doc->id }}">
                        Edit
                    </button>
                    <form action="{{ route('admin.kms.dokumen.destroy', $doc) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus dokumen ini?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>

            <div class="modal fade" id="modalEditDokumen{{ $doc->id }}">
                <div class="modal-dialog">
                    <form action="{{ route('admin.kms.dokumen.update', $doc) }}" method="POST" enctype="multipart/form-data" class="modal-content">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control mb-2" value="{{ $doc->title }}" required>

                            <label class="form-label">Tag (opsional)</label>
                            <input type="text" name="tag" class="form-control mb-2" value="{{ $doc->tag }}">

                            <label class="form-label">Ganti File (opsional, biarkan kosong jika tidak diganti)</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-dark">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada dokumen di kategori ini.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="modal fade" id="modalTambahDokumen">
    <div class="modal-dialog">
        <form action="{{ route('admin.kms.dokumen.store', $category) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control mb-2" required>

                <label class="form-label">Tag (opsional, bebas isi apa saja untuk pengelompokan ringan)</label>
                <input type="text" name="tag" class="form-control mb-2" placeholder="Contoh: Materi, Prakdit">

                <label class="form-label">File (PDF/DOC/DOCX/PPT/PPTX/XLS/XLSX, maks 20MB)</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button class="btn btn-dark">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
