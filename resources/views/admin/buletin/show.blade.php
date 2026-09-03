@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Buletin</h2>
            <p class="text-muted mb-0">
                Informasi Buletin Pengawasan Inspektorat
            </p>
        </div>

        <a href="{{ route('admin.buletin.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    {{-- Detail --}}
    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <div class="row g-4">

                {{-- Foto --}}
                <div class="col-md-5">

                    @if($buletin->foto)

                        <img
                            src="{{ asset('storage/' . $buletin->foto) }}"
                            alt="{{ $buletin->judul }}"
                            class="img-fluid rounded shadow-sm"
                            style="
                                width: 100%;
                                max-height: 450px;
                                object-fit: cover;
                            "
                        >

                    @else

                        <div
                            class="bg-light rounded d-flex align-items-center justify-content-center"
                            style="height: 350px;"
                        >
                            <span class="text-muted">
                                Tidak ada foto
                            </span>
                        </div>

                    @endif

                </div>

                {{-- Informasi --}}
                <div class="col-md-7">

                    <h2 class="fw-bold mb-3">
                        {{ $buletin->judul }}
                    </h2>

                    @if($buletin->kategori)

                        <span class="badge bg-secondary mb-3">
                            {{ $buletin->kategori }}
                        </span>

                    @endif

                    <hr>

                    <div class="mb-3">

                        <h6 class="fw-bold">
                            📅 Tanggal Kegiatan
                        </h6>

                        <p class="text-muted">
                            @if($buletin->tanggal)
                                {{ $buletin->tanggal->format('d F Y') }}
                            @else
                                -
                            @endif
                        </p>

                    </div>

                    <div class="mb-4">

                        <h6 class="fw-bold">
                            📝 Deskripsi
                        </h6>

                        <p class="text-muted" style="line-height: 1.8;">
                            {{ $buletin->deskripsi ?: 'Tidak ada deskripsi.' }}
                        </p>

                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex gap-2">

                        <a
                            href="{{ route('admin.buletin.edit', $buletin) }}"
                            class="btn btn-warning"
                        >
                            ✏️ Edit
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
                                class="btn btn-danger"
                            >
                                🗑️ Hapus
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection