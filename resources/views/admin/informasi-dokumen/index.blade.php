@extends('admin.layout')

@section('title', 'Dokumen Informasi')

@section('content')
<style>
.admin-pagination { display:flex; align-items:center; gap:6px; margin-top:16px; flex-wrap:wrap; }
.admin-pagination a, .admin-pagination span { padding:6px 12px; border-radius:6px; border:1px solid #e4e8ee; text-decoration:none; font-size:13px; color:#0b2545; }
.admin-pagination a:hover { background:#f1f5f9; }
.admin-pagination .admin-pagination-active { background:#0b2545; color:#fff; border-color:#0b2545; }
.admin-pagination .admin-pagination-disabled { color:#94a3b8; cursor:default; }
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px;">
    <h1>Dokumen Informasi (SOP, IKM, dll)</h1>
    <a href="{{ route('admin.informasidokumen.create') }}" class="admin-btn admin-btn-primary">+ Tambah Dokumen</a>
</div>

<div style="margin-bottom:16px; display:flex; gap:8px; flex-wrap:wrap;">
    <a href="{{ route('admin.informasidokumen.index') }}" style="padding:6px 14px;border-radius:20px;border:1px solid #e4e8ee;text-decoration:none;{{ !$kategoriAktif ? 'background:#0b2545;color:#fff;' : 'color:#0b2545;' }}">
        Semua
    </a>
    @foreach ($kategoriList as $kat)
        <a href="{{ route('admin.informasidokumen.index', ['kategori' => $kat]) }}" style="padding:6px 14px;border-radius:20px;border:1px solid #e4e8ee;text-decoration:none;{{ $kategoriAktif === $kat ? 'background:#0b2545;color:#fff;' : 'color:#0b2545;' }}">
            {{ $kat }}
        </a>
    @endforeach
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
                <tr>
                    <td>{{ $items->firstItem() + $loop->index }}</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>
                        @if ($item->file_url)
                            <a href="{{ $item->file_url }}" target="_blank" rel="noopener">Lihat PDF</a>
                        @else
                            &mdash;
                        @endif
                    </td>
                    <td style="display:flex; gap:12px;">
                        <a href="{{ route('admin.informasidokumen.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.informasidokumen.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color:#b91c1c; background:none; border:none; cursor:pointer; padding:0;">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">Belum ada dokumen.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="admin-pagination">
    @if ($items->hasPages())
        @if ($items->onFirstPage())
            <span class="admin-pagination-disabled">&lsaquo; Sebelumnya</span>
        @else
            <a href="{{ $items->previousPageUrl() }}">&lsaquo; Sebelumnya</a>
        @endif

        @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
            @if ($page == $items->currentPage())
                <span class="admin-pagination-active">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if ($items->hasMorePages())
            <a href="{{ $items->nextPageUrl() }}">Selanjutnya &rsaquo;</a>
        @else
            <span class="admin-pagination-disabled">Selanjutnya &rsaquo;</span>
        @endif
    @endif
</div>
</div>

<div style="margin-top:16px;">
    
</div>
@endsection
