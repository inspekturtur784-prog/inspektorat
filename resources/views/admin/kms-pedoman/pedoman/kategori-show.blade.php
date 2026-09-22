@extends('admin.layout')
@section('title', $kategori->nama)

@section('content')
<style>
    .kp-wrap { font-family:inherit; }
    .kp-back { display:inline-block; margin-bottom:14px; color:#1e2a4a; text-decoration:none; font-size:14px; }
    .kp-back:hover { text-decoration:underline; }
    .kp-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0; }
    .kp-btn { border:none; cursor:pointer; padding:9px 16px; border-radius:999px; font-size:13px; font-weight:600; text-decoration:none; display:inline-block; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; color:#fff; }
    .kp-btn-outline { background:#eeece6; color:#333; margin-right:6px; }
    .kp-btn-outline:hover { background:#e2ded4; color:#333; }
    .kp-btn-danger { background:#8b1e2b; color:#fff; }
    .kp-btn-danger:hover { background:#a3242f; color:#fff; }
    .kp-card { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06); overflow:hidden; }
    .kp-table { width:100%; border-collapse:collapse; }
    .kp-table thead th { text-align:left; font-size:11px; letter-spacing:.05em; text-transform:uppercase; color:#8b8b8b; padding:14px 18px; border-bottom:1px solid #eee; }
    .kp-table tbody td { padding:14px 18px; border-bottom:1px solid #f2f2f2; font-size:14px; color:#333; }
    .kp-table tbody tr:last-child td { border-bottom:none; }
    .kp-table tbody tr:hover { background:#fafafa; }
    .kp-empty { text-align:center; color:#999; padding:28px; }
</style>

<a href="{{ route('admin.kms.index') }}" class="kp-back">&larr; Kembali ke KMS &amp; Pedoman</a>

<div class="kp-header">
    <h1>{{ $kategori->nama }}</h1>
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
                    <td>
                        <a href="{{ url('/files/' . $doc->file_path) }}" target="_blank" class="kp-btn kp-btn-outline">Lihat</a>
                        <a href="{{ route('admin.pedoman.dokumen.edit', $doc) }}" class="kp-btn kp-btn-outline">Edit</a>
                        <form action="{{ route('admin.pedoman.dokumen.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="kp-empty">Belum ada dokumen di kategori ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection