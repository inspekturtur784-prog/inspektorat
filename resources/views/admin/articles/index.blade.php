@extends('admin.layout')
@section('title', 'Kelola Artikel')

@section('content')
<div class="admin-header">
    <h1>Artikel / Informasi Terbaru</h1>
    <a href="{{ route('admin.articles.create') }}" class="btn-admin btn-admin-primary">+ Tambah Artikel</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($articles as $article)
            <tr>
                <td>{{ $article->title }}</td>
                <td>{{ $article->category ?? '—' }}</td>
                <td>{{ $article->tanggal_indo }}</td>
                <td>
                    @if ($article->is_published)
                        <span class="badge badge-on">Tayang</span>
                    @else
                        <span class="badge badge-off">Draft</span>
                    @endif
                </td>
                <td class="row-actions">
                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada artikel. Klik "Tambah Artikel" untuk membuat yang pertama.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $articles->links() }}</div>
@endsection