@extends('admin.layout')
@section('title', 'Tentang Inspektorat')

@section('content')
<style>
    #tentang_intro{ transition: border-color .15s ease, box-shadow .15s ease, background .15s ease; resize: vertical; line-height: 1.7; }
    #tentang_intro[readonly]{ background: #f7f8fa; cursor: default; }
    #tentang_intro:not([readonly]){ border-color: var(--navy, #0b2545); box-shadow: 0 0 0 3px rgba(11,37,69,.10); background: #fff; }
    .tentang-aksi{ display: flex; align-items: center; gap: 10px; margin-top: 16px; }
    .tentang-aksi .btn-batal{
        background: #e4e8ee; color: var(--navy, #0b2545); border: none; cursor: pointer;
        padding: 10px 22px; border-radius: 999px; font-weight: 600; font-size: 14px; transition: background .15s ease;
    }
    .tentang-aksi .btn-batal:hover{ background: #d3d9e2; }
    .tentang-status{ font-size: 12.5px; color: var(--slate, #5b6b7d); }
</style>

<div class="admin-header">
    <h1>Tentang Inspektorat</h1>
</div>
<p style="color:var(--slate, #5b6b7d);font-size:13.5px;margin:-10px 0 28px;">
    Teks ini tampil di Beranda, pada bagian "Mengenal Kami".
</p>

<form action="{{ route('admin.pengaturan.tentang.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="tentang_intro">Paragraf Pembuka</label>
        <textarea id="tentang_intro" name="tentang_intro" rows="4" required readonly>{{ old('tentang_intro', $p['tentang_intro'] ?? '') }}</textarea>
    </div>

    <div class="tentang-aksi">
        <button type="button" id="btn-edit-tentang" class="btn-admin btn-admin-primary">Edit</button>
        <button type="submit" id="btn-simpan-tentang" class="btn-admin btn-admin-primary" style="display:none;">Simpan Perubahan</button>
        <button type="button" id="btn-batal-tentang" class="btn-batal" style="display:none;">Batal</button>
        <span id="tentang-status" class="tentang-status" style="display:none;">Sedang mengedit</span>
    </div>
</form>

<script>
(function () {
    var ta = document.getElementById('tentang_intro');
    var be = document.getElementById('btn-edit-tentang');
    var bs = document.getElementById('btn-simpan-tentang');
    var bb = document.getElementById('btn-batal-tentang');
    var st = document.getElementById('tentang-status');
    var asli = ta.value;

    function sesuaikan() {
        ta.style.height = 'auto';
        ta.style.height = (ta.scrollHeight + 4) + 'px';
    }
    function mulai() {
        ta.removeAttribute('readonly');
        be.style.display = 'none';
        bs.style.display = '';
        bb.style.display = '';
        st.style.display = '';
        ta.focus();
        ta.setSelectionRange(ta.value.length, ta.value.length);
    }
    function batal() {
        if (ta.value !== asli && !confirm('Perubahan belum disimpan. Yakin batal?')) { return; }
        ta.value = asli;
        ta.setAttribute('readonly', 'readonly');
        be.style.display = '';
        bs.style.display = 'none';
        bb.style.display = 'none';
        st.style.display = 'none';
        sesuaikan();
    }

    be.addEventListener('click', mulai);
    bb.addEventListener('click', batal);
    ta.addEventListener('input', sesuaikan);
    sesuaikan();
    if ({{ $errors->any() ? 'true' : 'false' }}) { mulai(); }
})();
</script>
@endsection