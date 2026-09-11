@extends('admin.layout')

@section('title', 'Kartu Profil')

@section('content')
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <h1 style="font-size:22px;margin:0;">Kartu Profil (Kedudukan, dll)</h1>
        <a href="{{ route('admin.profilhighlight.create') }}" class="admin-sidebar-link" style="background:var(--navy,#0b2545);color:#fff;padding:10px 18px;border-radius:6px;text-decoration:none;display:inline-block;">
            + Tambah Kartu
        </a>
    </div>

    <p style="color:#5b6b7d;font-size:13.5px;margin-bottom:20px;">
        Kartu-kartu ini yang tampil di bagian "Mengenal Kami" — biasanya diisi Kedudukan, Peran, Tujuan, Fungsi, tapi kamu bisa tambah/hapus/urutkan bebas.
    </p>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:60px;">Urutan</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th style="width:160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->urutan }}</td>
                        <td><strong>{{ $item->judul }}</strong></td>
                        <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}</td>
                        <td>
                            <a href="{{ route('admin.profilhighlight.edit', $item) }}">Edit</a>
                            &nbsp;|&nbsp;
                            <form action="{{ route('admin.profilhighlight.destroy', $item) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus kartu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background:none;border:none;color:#c0392b;cursor:pointer;padding:0;font:inherit;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#5b6b7d;padding:24px;">
                            Belum ada kartu profil. Klik "+ Tambah Kartu" untuk membuat yang pertama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection