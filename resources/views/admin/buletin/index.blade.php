@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Buletin Pengawasan</h2>
            <p class="text-muted mb-0">
                Kelola Buletin Pengawasan Inspektorat Kota Mojokerto
            </p>
        </div>

        <a href="{{ route('admin.buletin.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i>
            Tambah Buletin
        </a>
    </div>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Daftar Buletin --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            @if($buletins->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>
                                <th width="80">No</th>
                                <th width="130">Foto</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($buletins as $index => $buletin)

                                <tr>

                                    {{-- Nomor --}}
                                    <td>
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- Foto --}}
                                    <td>

                                        @if($buletin->foto)

                                            <img
                                                src="{{ asset('storage/' . $buletin->foto) }}"
                                                alt="{{ $buletin->judul }}"
                                                width="100"
                                                height="70"
                                                style="object-fit: cover; border-radius: 8px;"
                                            >

                                        @else

                                            <div
                                                class="bg-light d-flex align-items-center justify-content-center"
                                                style="width:100px;height:70px;border-radius:8px;"
                                            >
                                                <span class="text-muted">
                                                    Tidak ada foto
                                                </span>
                                            </div>

                                        @endif

                                    </td>

                                    {{-- Judul --}}
                                    <td>
                                        <strong>
                                            {{ $buletin->judul }}
                                        </strong>

                                        @if($buletin->deskripsi)

                                            <div class="small text-muted mt-1">
                                                {{ Str::limit($buletin->deskripsi, 80) }}
                                            </div>

                                        @endif
                                    </td>

                                    {{-- Kategori --}}
                                    <td>

                                        @if($buletin->kategori)

                                            <span class="badge bg-secondary">
                                                {{ $buletin->kategori }}
                                            </span>

                                        @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tanggal --}}
                                    <td>

                                        @if($buletin->tanggal)
                                            {{ $buletin->tanggal->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif

                                    </td>

                                    {{-- Aksi --}}
                                    <td>

                                        <div class="d-flex gap-1">

                                            <a
                                                href="{{ route('admin.buletin.show', $buletin) }}"
                                                class="btn btn-sm btn-info text-white"
                                            >
                                                Lihat
                                            </a>

                                            <a
                                                href="{{ route('admin.buletin.edit', $buletin) }}"
                                                class="btn btn-sm btn-warning"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('admin.buletin.destroy', $buletin) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus buletin ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                {{-- Kalau belum ada data --}}
                <div class="text-center py-5">

                    <div class="mb-3" style="font-size: 50px;">
                        📰
                    </div>

                    <h5 class="fw-bold">
                        Belum Ada Buletin
                    </h5>

                    <p class="text-muted">
                        Belum ada Buletin Pengawasan yang ditambahkan.
                    </p>

                    <a
                        href="{{ route('admin.buletin.create') }}"
                        class="btn btn-primary"
                    >
                        + Tambah Buletin
                    </a>

                </div>

            @endif

        </div>
    </div>

</div>

@endsection