@extends('admin.layout')

@section('title', $item->exists ? 'Edit Kartu Profil' : 'Tambah Kartu Profil')

@section('content')
    <h1 style="font-size:22px;margin-bottom:20px;">
        {{ $item->exists ? 'Edit Kartu Profil' : 'Tambah Kartu Profil' }}
    </h1>

    @if ($errors->any())
        <div class="admin-alert" style="background:#fdecea;color:#c0392b;">
            <ul style="margin:0;padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $item->exists ? route('admin.profilhighlight.update', $item) : route('admin.profilhighlight.store') }}" method="POST" style="max-width:560px;">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <div style="margin-bottom:18px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $item->judul) }}" required
                   style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;"
                   placeholder="Contoh: Kedudukan">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Deskripsi</label>
            <textarea name="deskripsi" rows="4" required
                      style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;resize:vertical;"
                      placeholder="Penjelasan singkat kartu ini">{{ old('deskripsi', $item->deskripsi) }}</textarea>
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Icon (opsional)</label>
            <input type="text" name="icon" value="{{ old('icon', $item->icon) }}"
                   style="width:100%;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;"
                   placeholder="Key ikon, mis. building / users / target">
            <small style="color:#5b6b7d;">Isi sesuai key ikon yang tersedia di <code>partials/icon.blade.php</code>. Kosongkan kalau tidak perlu ikon.</small>
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block;font-weight:600;margin-bottom:6px;">Urutan Tampil</label>
            <input type="number" name="urutan" value="{{ old('urutan', $item->urutan ?? 0) }}" min="0"
                   style="width:140px;padding:10px 12px;border:1px solid #e4e8ee;border-radius:6px;font-size:14px;">
            <small style="color:#5b6b7d;display:block;">Angka kecil tampil lebih dulu.</small>
        </div>

        <div style="display:flex;gap:12px;">
            <button type="submit" style="background:var(--navy,#0b2545);color:#fff;padding:11px 24px;border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                Simpan
            </button>
            <a href="{{ route('admin.profilhighlight.index') }}" style="padding:11px 24px;color:#0b2545;text-decoration:none;">
                Batal
            </a>
        </div>
    </form>
@endsection