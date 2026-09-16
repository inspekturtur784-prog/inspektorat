@extends('admin.layout')
@section('title', 'KMS & Pedoman')

@section('content')
<style>
    .kp-wrap { font-family:inherit; }
    .kp-section { margin-bottom:40px; }
    .kp-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; flex-wrap:wrap; gap:10px; }
    .kp-header h1 { font-size:22px; font-weight:700; color:#1e2a4a; margin:0; }
    .kp-header h2 { font-size:18px; font-weight:700; color:#1e2a4a; margin:0; }
    .kp-header p.kp-count { font-size:13px; color:#888; margin:2px 0 0; }
    .kp-btn { border:none; cursor:pointer; padding:9px 16px; border-radius:999px; font-size:13px; font-weight:600; text-decoration:none; display:inline-block; }
    .kp-btn-primary { background:#1e2a4a; color:#fff; }
    .kp-btn-primary:hover { background:#28345c; color:#fff; }
    .kp-btn-outline { background:#eeece6; color:#333; margin-right:6px; }
    .kp-btn-outline:hover { background:#e2ded4; color:#333; }
    .kp-btn-danger { background:#8b1e2b; color:#fff; }
    .kp-btn-danger:hover { background:#a3242f; color:#fff; }
    .kp-status { background:#e6f4ea; color:#256029; padding:10px 16px; border-radius:8px; margin-bottom:20px; font-size:14px; }
    .kp-card { background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06); overflow:hidden; margin-bottom:24px; }
    .kp-table { width:100%; border-collapse:collapse; }
    .kp-table thead th { text-align:left; font-size:11px; letter-spacing:.05em; text-transform:uppercase; color:#8b8b8b; padding:14px 18px; border-bottom:1px solid #eee; }
    .kp-table tbody td { padding:14px 18px; border-bottom:1px solid #f2f2f2; font-size:14px; color:#333; }
    .kp-table tbody tr:last-child td { border-bottom:none; }
    .kp-table tbody tr:hover { background:#fafafa; }
    .kp-empty { text-align:center; color:#999; padding:28px; }
    .kp-divider { border:none; border-top:1px solid #e5e2da; margin:36px 0; }
    .kp-subtitle { font-size:15px; font-weight:700; color:#1e2a4a; margin:0 0 14px; }
</style>

<div class="kp-wrap">
    <div class="kp-header">
        <h1>KMS &amp; Pedoman</h1>
    </div>

    @if (session('status'))
        <div class="kp-status">{{ session('status') }}</div>
    @endif

    <div class="kp-section">
        <div class="kp-header">
            <div>
                <h2>Knowledge Base (KMS)</h2>
                <p class="kp-count">{{ $kmsKategoris->count() }} kategori &middot; {{ $kmsDokumens->count() }} dokumen</p>
            </div>
            <a href="{{ route('admin.kms.kategori.create') }}" class="kp-btn kp-btn-primary">+ Tambah Kategori KMS</a>
        </div>

        <div class="kp-card">
            <table class="kp-table">
                <thead><tr><th>Nama Kategori</th><th style="width:220px;">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($kmsKategoris as $kategori)
                    <tr>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="{{ route('admin.kms.kategori.show', $kategori) }}" class="kp-btn kp-btn-outline">Kelola</a>
                            <a href="{{ route('admin.kms.kategori.edit', $kategori) }}" class="kp-btn kp-btn-outline">Edit</a>
                            <form action="{{ route('admin.kms.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta semua isinya?');" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="kp-empty">Belum ada kategori KMS.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <p class="kp-subtitle">Semua Dokumen KMS</p>
        <div class="kp-card">
            <table class="kp-table">
                <thead><tr><th>Judul</th><th>Kategori</th><th>Subkategori</th><th>Grup</th><th style="width:160px;">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($kmsDokumens as $doc)
                    <tr>
                        <td>{{ $doc->judul }}</td>
                        <td>{{ $doc->kategori->nama ?? '-' }}</td>
                        <td>{{ $doc->subkategori->nama ?? '-' }}</td>
                        <td>{{ $doc->grupDokumen->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ asset('kms-files/' . $doc->file_path) }}" target="_blank" class="kp-btn kp-btn-outline">Lihat</a>
                            <a href="{{ route('admin.kms.dokumen.edit', $doc) }}" class="kp-btn kp-btn-outline">Edit</a>
                            <form action="{{ route('admin.kms.dokumen.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="kp-empty">Belum ada dokumen KMS.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <hr class="kp-divider">

    <div class="kp-section">
        <div class="kp-header">
            <div>
                <h2>Pedoman</h2>
                <p class="kp-count">{{ $pedomanKategoris->count() }} kategori &middot; {{ $pedomanDokumens->count() }} dokumen</p>
            </div>
            <div>
                <a href="{{ route('admin.pedoman.kategori.create') }}" class="kp-btn kp-btn-outline">+ Tambah Kategori</a>
                <a href="{{ route('admin.pedoman.dokumen.create') }}" class="kp-btn kp-btn-primary">+ Tambah Dokumen</a>
            </div>
        </div>

        <div class="kp-card">
            <table class="kp-table">
                <thead><tr><th>Nama Kategori</th><th>Jumlah Dokumen</th><th style="width:160px;">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($pedomanKategoris as $kategori)
                    <tr>
                        <td>{{ $kategori->nama }}</td>
                        <td>{{ $pedomanDokumens->where('pedoman_kategori_id', $kategori->id)->count() }}</td>
                        <td>
                            <a href="{{ route('admin.pedoman.kategori.edit', $kategori) }}" class="kp-btn kp-btn-outline">Edit</a>
                            <form action="{{ route('admin.pedoman.kategori.destroy', $kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori pedoman ini?');" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="kp-empty">Belum ada kategori Pedoman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <p class="kp-subtitle">Semua Dokumen Pedoman</p>
        <div class="kp-card">
            <table class="kp-table">
                <thead><tr><th>Judul</th><th>Kategori</th><th style="width:160px;">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($pedomanDokumens as $doc)
                    <tr>
                        <td>{{ $doc->judul }}</td>
                        <td>{{ $doc->kategori->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ asset($doc->file_path) }}" target="_blank" class="kp-btn kp-btn-outline">Lihat</a>
                            <a href="{{ route('admin.pedoman.dokumen.edit', $doc) }}" class="kp-btn kp-btn-outline">Edit</a>
                            <form action="{{ route('admin.pedoman.dokumen.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen pedoman ini?');" style="display:inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="kp-btn kp-btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="kp-empty">Belum ada dokumen Pedoman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection