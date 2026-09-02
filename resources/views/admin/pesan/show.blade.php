@extends('admin.layout')
@section('title', 'Detail Pesan')

@section('content')
<div class="admin-header">
    <h1>Pesan dari {{ $pesan->nama }}</h1>
</div>

<div class="admin-form" style="max-width:640px;">
    <div class="form-group">
        <label>Nama</label>
        <p style="margin:0;">{{ $pesan->nama }}</p>
    </div>
    <div class="form-group">
        <label>Email</label>
        <p style="margin:0;"><a href="mailto:{{ $pesan->email }}">{{ $pesan->email }}</a></p>
    </div>
    @if ($pesan->telepon)
        <div class="form-group">
            <label>No. Telepon</label>
            <p style="margin:0;">{{ $pesan->telepon }}</p>
        </div>
    @endif
    <div class="form-group">
        <label>Tanggal Masuk</label>
        <p style="margin:0;">{{ $pesan->created_at->format('d F Y, H:i') }} WIB</p>
    </div>
    <div class="form-group">
        <label>Isi Pesan</label>
        <p style="margin:0;white-space:pre-line;line-height:1.7;">{{ $pesan->pesan }}</p>
    </div>

    <a href="{{ route('admin.pesan.index') }}" class="btn-admin btn-admin-ghost">← Kembali ke Pesan Masuk</a>
    <form action="{{ route('admin.pesan.destroy', $pesan) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus pesan ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-admin btn-admin-danger">Hapus Pesan</button>
    </form>
</div>
@endsection