@extends('layouts.admin')

@section('content')
<style>
    .kms-wrap { font-family: inherit; }
    .kms-back { display:inline-block; margin-bottom:14px; color:#1e2a4a; text-decoration:none; font-size:14px; }
    .kms-back:hover { text-decoration:underline; }
    .kms-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
    .kms-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0; }
    .kms-btn { border:none; cursor:pointer; padding:10px 18px; border-radius:999px; font-size:14px; font-weight:600; }
    .kms-btn-primary { background:#1e2a4a; color:#fff; }
    .kms-btn-primary:hover { background:#28345c; }
    .kms-btn-outline { background:#eeece6; color:#333; margin-right:6px; }
    .kms-btn-outline:hover { background:#e2ded4; }
    .kms-btn-danger { background:#8b1e2b; color:#fff; }
    .kms-btn-danger:hover { background:#a3242f; }
    .kms-alert { background:#e6f4ea; color:#256029; padding:12px 16px; border-radius:8px; margin-bottom:18px; font-size:14px; }
    .kms-card { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06); overflow:hidden; }
    .kms-table { width:100%; border-collapse:collapse; }
    .kms-table thead th { text-align:left; font-size:12px; letter-spacing:.05em; text-transform:uppercase; color:#8b8b8b; padding:16px 20px; border-bottom:1px solid #eee; }
    .kms-table tbody td { padding:16px 20px; border-bottom:1px solid #f2f2f2; font-size:14px; color:#333; }
    .kms-table tbody tr:last-child td { border-bottom:none; }
    .kms-table tbody tr:hover { background:#fafafa; }
    .kms-empty { text-align:center; color:#999; padding:32px; }
    .kms-modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.45); align-items:center; justify-content:center; z-index:1000; }
    .kms-modal-overlay.active { display:flex; }
    .kms-modal { background:#fff; border-radius:12px; width:100%; max-width:440px; padding:24px; box-shadow:0 10px 30px rgba(0,0,0,.2); }
    .kms-modal h3 { margin:0 0 16px; font-size:18px; color:#1e2a4a; }
    .kms-modal label { display:block; font-size:13px; font-weight:600; color:#555; margin-bottom:6px; margin-top:12px; }
    .kms-modal label:first-of-type { margin-top:0; }
    .kms-modal input[type=text], .kms-modal input[type=file] { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; font-size:14px; box-sizing:border-box; }
    .kms-modal-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:20px; }
    .kms-modal-actions .kms-btn-cancel { background:#f0f0f0; color:#555; }
    .kms-tag { display:inline-block; background:#f0eee8; color:#555; font-size:12px; padding:3px 10px; border-radius:999px; }
</style>

<div class="kms-wrap">
    <a href="{{ route('admin.kms.index') }}" class="kms-back">&larr; Kembali ke daftar kategori</a>

    <div class="kms-header">
        <h1>{{ $category->name }}</h1>
        <button type="button" class="kms-btn kms-btn-primary" onclick="kmsOpen('modalTambahDokumen')">+ Tambah Dokumen</button>
    </div>

    @if (session('success'))
        <div class="kms-alert">{{ session('success') }}</div>
    @endif

    <div class="kms-card">
        <table class="kms-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Tag</th>
                    <th>Tipe File</th>
                    <th>Dilihat</th>
                    <th style="width:220px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($documents as $doc)
                    <tr>
                        <td>{{ $doc->title }}</td>
                        <td>@if($doc->tag)<span class="kms-tag">{{ $doc->tag }}</span>@else - @endif</td>
                        <td>{{ $doc->file_type }}</td>
                        <td>{{ $doc->views }}</td>
                        <td>
                            <button type="button" class="kms-btn kms-btn-outline" onclick="kmsOpen('modalEditDokumen{{ $doc->id }}')">Edit</button>
                            <form action="{{ route('admin.kms.dokumen.destroy', $doc) }}" method="POST" style="display:inline"
                                  onsubmit="return confirm('Hapus dokumen ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="kms-btn kms-btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="kms-modal-overlay" id="modalEditDokumen{{ $doc->id }}">
                        <div class="kms-modal">
                            <h3>Edit Dokumen</h3>
                            <form action="{{ route('admin.kms.dokumen.update', $doc) }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <label>Judul</label>
                                <input type="text" name="title" value="{{ $doc->title }}" required>
                                <label>Tag (opsional)</label>
                                <input type="text" name="tag" value="{{ $doc->tag }}">
                                <label>Ganti File (opsional)</label>
                                <input type="file" name="file">
                                <div class="kms-modal-actions">
                                    <button type="button" class="kms-btn kms-btn-cancel" onclick="kmsClose('modalEditDokumen{{ $doc->id }}')">Batal</button>
                                    <button type="submit" class="kms-btn kms-btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="5" class="kms-empty">Belum ada dokumen di kategori ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="kms-modal-overlay" id="modalTambahDokumen">
    <div class="kms-modal">
        <h3>Tambah Dokumen</h3>
        <form action="{{ route('admin.kms.dokumen.store', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label>Judul</label>
            <input type="text" name="title" required>
            <label>Tag (opsional, bebas isi apa saja)</label>
            <input type="text" name="tag" placeholder="Contoh: Materi, Prakdit">
            <label>File (PDF/DOC/DOCX/PPT/PPTX/XLS/XLSX, maks 20MB)</label>
            <input type="file" name="file" required>
            <div class="kms-modal-actions">
                <button type="button" class="kms-btn kms-btn-cancel" onclick="kmsClose('modalTambahDokumen')">Batal</button>
                <button type="submit" class="kms-btn kms-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function kmsOpen(id) { document.getElementById(id).classList.add('active'); }
    function kmsClose(id) { document.getElementById(id).classList.remove('active'); }
    document.querySelectorAll('.kms-modal-overlay').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (e.target === el) el.classList.remove('active');
        });
    });
</script>
@endsection