@extends('admin.layouts.app')

@section('title', 'KMS / Pedoman')

@section('content')
<h1 style="margin-bottom: 4px;">KMS / Pedoman</h1>
<p style="color:#666; margin-bottom: 20px;">Kelola konten Knowledge Base dan Pedoman dalam satu halaman.</p>

<div class="admin-tabs" style="display:flex; gap:8px; border-bottom:1px solid #ddd; margin-bottom:20px;">
    <button type="button" class="kp-tab-btn active" data-tab="kms" style="padding:10px 18px; border:none; background:none; cursor:pointer; font-weight:600; border-bottom:2px solid #1e3a5f;">
        Knowledge Base
    </button>
    <button type="button" class="kp-tab-btn" data-tab="pedoman" style="padding:10px 18px; border:none; background:none; cursor:pointer; font-weight:600; border-bottom:2px solid transparent; color:#888;">
        Pedoman
    </button>
</div>

{{-- ===================== TAB: KMS ===================== --}}
<div class="kp-tab-panel" id="kp-tab-kms">

    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 10px;">
        <h2 style="margin:0;">Kategori</h2>
        <a href="{{ route('admin.kms-kategori.create') }}" class="admin-btn">+ Tambah Kategori</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Nama</th><th>Slug</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kmsKategoris as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        <a href="{{ route('admin.kms-kategori.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.kms-kategori.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini? Subkategori/dokumen terkait bisa ikut terhapus.');">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b00020;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 10px;">
        <h2 style="margin:0;">Subkategori</h2>
        <a href="{{ route('admin.kms-subkategori.create') }}" class="admin-btn">+ Tambah Subkategori</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Nama</th><th>Kategori</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kmsSubkategoris as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.kms-subkategori.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.kms-subkategori.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus subkategori ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b00020;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Belum ada subkategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 10px;">
        <h2 style="margin:0;">Grup Dokumen</h2>
        <a href="{{ route('admin.kms-grup.create') }}" class="admin-btn">+ Tambah Grup</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Nama</th><th>Subkategori</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kmsGrups as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->subkategori->nama ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.kms-grup.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.kms-grup.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus grup dokumen ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b00020;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Belum ada grup dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 10px;">
        <h2 style="margin:0;">Dokumen</h2>
        <a href="{{ route('admin.kms-dokumen.create') }}" class="admin-btn">+ Tambah Dokumen (Upload PDF)</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Judul</th><th>Kategori</th><th>Dilihat</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($kmsDokumens as $item)
                <tr>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->dilihat }}</td>
                    <td>
                        <a href="{{ route('admin.kms-dokumen.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.kms-dokumen.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus dokumen ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b00020;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===================== TAB: PEDOMAN ===================== --}}
<div class="kp-tab-panel" id="kp-tab-pedoman" style="display:none;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 10px;">
        <h2 style="margin:0;">Kategori Pedoman</h2>
        <a href="{{ route('admin.pedoman-kategori.create') }}" class="admin-btn">+ Tambah Kategori</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Nama</th><th>Slug</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($pedomanKategoris as $item)
                <tr>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        <a href="{{ route('admin.pedoman-kategori.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.pedoman-kategori.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini? Dokumen terkait bisa ikut terhapus.');">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b00020;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin: 24px 0 10px;">
        <h2 style="margin:0;">Dokumen Pedoman</h2>
        <a href="{{ route('admin.pedoman-dokumen.create') }}" class="admin-btn">+ Tambah Dokumen (Upload PDF)</a>
    </div>
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead><tr><th>Judul</th><th>Kategori</th><th>Ukuran</th><th>Download</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($pedomanDokumens as $item)
                <tr>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>{{ $item->ukuran_kb ? $item->ukuran_kb . ' KB' : '-' }}</td>
                    <td>{{ $item->downloads }}</td>
                    <td>
                        <a href="{{ route('admin.pedoman-dokumen.edit', $item) }}">Edit</a>
                        <form action="{{ route('admin.pedoman-dokumen.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus dokumen ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="border:none;background:none;color:#b00020;cursor:pointer;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5">Belum ada dokumen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    (function () {
        var buttons = document.querySelectorAll('.kp-tab-btn');
        var panels = {
            kms: document.getElementById('kp-tab-kms'),
            pedoman: document.getElementById('kp-tab-pedoman')
        };
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                buttons.forEach(function (b) {
                    b.classList.remove('active');
                    b.style.borderBottomColor = 'transparent';
                    b.style.color = '#888';
                });
                btn.classList.add('active');
                btn.style.borderBottomColor = '#1e3a5f';
                btn.style.color = '#000';

                Object.keys(panels).forEach(function (key) {
                    panels[key].style.display = (key === btn.dataset.tab) ? 'block' : 'none';
                });
            });
        });
    })();
</script>
@endsection
