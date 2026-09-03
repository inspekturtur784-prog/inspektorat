@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Buletin</h2>
            <p class="text-muted mb-0">
                Perbarui informasi Buletin Pengawasan
            </p>
        </div>

        <a href="{{ route('admin.buletin.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <form
                action="{{ route('admin.buletin.update', $buletin) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="judul" class="form-label fw-semibold">
                        Judul Buletin
                    </label>

                    <input
                        type="text"
                        name="judul"
                        id="judul"
                        class="form-control"
                        value="{{ old('judul', $buletin->judul) }}"
                        required
                    >
                </div>

                {{-- Kategori --}}
                <div class="mb-3">
                    <label for="kategori" class="form-label fw-semibold">
                        Kategori
                    </label>

                    <select
                        name="kategori"
                        id="kategori"
                        class="form-select"
                    >
                        <option value="">-- Pilih Kategori --</option>

                        <option value="Kegiatan Pengawasan"
                            {{ old('kategori', $buletin->kategori) == 'Kegiatan Pengawasan' ? 'selected' : '' }}>
                            Kegiatan Pengawasan
                        </option>

                        <option value="Pencegahan Gratifikasi"
                            {{ old('kategori', $buletin->kategori) == 'Pencegahan Gratifikasi' ? 'selected' : '' }}>
                            Pencegahan Gratifikasi
                        </option>

                        <option value="Berita Inspektorat"
                            {{ old('kategori', $buletin->kategori) == 'Berita Inspektorat' ? 'selected' : '' }}>
                            Berita Inspektorat
                        </option>

                        <option value="Edukasi Pengawasan"
                            {{ old('kategori', $buletin->kategori) == 'Edukasi Pengawasan' ? 'selected' : '' }}>
                            Edukasi Pengawasan
                        </option>

                        <option value="Lainnya"
                            {{ old('kategori', $buletin->kategori) == 'Lainnya' ? 'selected' : '' }}>
                            Lainnya
                        </option>
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="mb-3">
                    <label for="tanggal" class="form-label fw-semibold">
                        Tanggal Kegiatan
                    </label>

                    <input
                        type="date"
                        name="tanggal"
                        id="tanggal"
                        class="form-control"
                        value="{{ old('tanggal', $buletin->tanggal) }}"
                    >
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label fw-semibold">
                        Deskripsi
                    </label>

                    <textarea
                        name="deskripsi"
                        id="deskripsi"
                        rows="6"
                        class="form-control"
                        placeholder="Tulis keterangan atau isi singkat buletin..."
                    >{{ old('deskripsi', $buletin->deskripsi) }}</textarea>
                </div>

                {{-- Foto Lama --}}
                @if($buletin->foto)

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Foto Saat Ini
                        </label>

                        <div>
                            <img
                                src="{{ asset('storage/' . $buletin->foto) }}"
                                alt="{{ $buletin->judul }}"
                                style="
                                    width: 220px;
                                    height: 150px;
                                    object-fit: cover;
                                    border-radius: 10px;
                                "
                            >
                        </div>
                    </div>

                @endif

                {{-- Foto Baru --}}
                <div class="mb-4">
                    <label for="foto" class="form-label fw-semibold">
                        Ganti Foto
                    </label>

                    <input
                        type="file"
                        name="foto"
                        id="foto"
                        class="form-control"
                        accept="image/jpeg,image/png,image/webp"
                    >

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti foto.
                        Maksimal 2 MB.
                    </small>
                </div>

                {{-- Tombol --}}
                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        💾 Simpan Perubahan
                    </button>

                    <a
                        href="{{ route('admin.buletin.index') }}"
                        class="btn btn-light"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection