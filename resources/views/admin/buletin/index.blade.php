@extends('admin.layout')
@section('title', 'Kelola Buletin')

@section('content')
<div class="admin-header">
    <h1>Buletin Pengawasan</h1>
    <a href="{{ route('admin.buletin.create') }}" class="btn-admin btn-admin-primary">+ Tambah Buletin</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Cover</th>
            <th>Judul</th>
            <th>Edisi</th>
            <th>Tema</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($buletins as $buletin)
            <tr>
                <td>
                    <img src="{{ $buletin->cover_url }}" alt="{{ $buletin->title }}"
                         style="width:48px;height:64px;object-fit:cover;object-position:{{ $buletin->image_position_css }};border-radius:4px;">
                </td>
                <td>{{ $buletin->title }}</td>
                <td>{{ $buletin->label ?? '—' }}</td>
                <td>
                    <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background:{{ $buletin->theme_color }};vertical-align:middle;margin-right:6px;"></span>
                    {{ ucfirst($buletin->theme ?? 'navy') }}
                </td>
                <td>
                    @if ($buletin->is_published)
                        <span class="badge badge-on">Tayang</span>
                    @else
                        <span class="badge badge-off">Draft</span>
                    @endif
                </td>
                <td class="row-actions">
                    <a href="{{ route('admin.buletin.edit', $buletin) }}" class="btn-admin btn-admin-ghost">Edit</a>
                    <form action="{{ route('admin.buletin.destroy', $buletin) }}" method="POST" onsubmit="return confirm('Hapus buletin ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada buletin. Klik "Tambah Buletin" untuk membuat yang pertama.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $buletins->links() }}</div>
@endsection