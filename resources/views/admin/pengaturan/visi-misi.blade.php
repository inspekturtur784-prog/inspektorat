@extends('admin.layout')
@section('title', 'Visi & Misi')

@section('content')
<style>
    .vm-box{ transition: border-color .15s ease, box-shadow .15s ease, background .15s ease; resize: vertical; line-height: 1.7; }
    .vm-box[readonly]{ background: #f7f8fa; cursor: default; }
    .vm-box:not([readonly]){ border-color: var(--navy, #0b2545); box-shadow: 0 0 0 3px rgba(11,37,69,.10); background: #fff; }
    .visimisi-aksi{ display: flex; align-items: center; gap: 10px; margin-top: 16px; }
    .visimisi-aksi .btn-batal{
        background: #e4e8ee; color: var(--navy, #0b2545); border: none; cursor: pointer;
        padding: 10px 22px; border-radius: 999px; font-weight: 600; font-size: 14px; transition: background .15s ease;
    }
    .visimisi-aksi .btn-batal:hover{ background: #d3d9e2; }
    .visimisi-status{ font-size: 12.5px; color: var(--slate, #5b6b7d); }
</style>

<div class="admin-header">
    <h1>Visi & Misi</h1>
</div>
<p style="color:var(--slate, #5b6b7d);font-size:13.5px;margin:-10px 0 28px;">
    Visi dan Misi tampil di halaman Profil.
</p>

<form action="{{ route('admin.pengaturan.visimisi.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="vm_visi">Visi</label>
        <textarea id="vm_visi" class="vm-box" name="visi" rows="3" required readonly>{{ old('visi', $p['visi'] ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label for="vm_misi">Misi (satu poin per baris)</label>
        <textarea id="vm_misi" class="vm-box" name="misi" rows="6" required readonly placeholder="Contoh:&#10;Mewujudkan tata kelola pemerintahan yang bersih&#10;Meningkatkan kualitas pengawasan internal">{{ old('misi', $p['misi'] ?? '') }}</textarea>
    </div>

    <div class="visimisi-aksi">
        <button type="button" id="btn-edit-visimisi" class="btn-admin btn-admin-primary">Edit</button>
        <button type="submit" id="btn-simpan-visimisi" class="btn-admin btn-admin-primary" style="display:none;">Simpan Perubahan</button>
        <button type="button" id="btn-batal-visimisi" class="btn-batal" style="display:none;">Batal</button>
        <span id="visimisi-status" class="visimisi-status" style="display:none;">Sedang mengedit</span>
    </div>
</form>

<script>
(function () {
    var boxes = [document.getElementById('vm_visi'), document.getElementById('vm_misi')];
    var be = document.getElementById('btn-edit-visimisi');
    var bs = document.getElementById('btn-simpan-visimisi');
    var bb = document.getElementById('btn-batal-visimisi');
    var st = document.getElementById('visimisi-status');
    var asli = boxes.map(function (b) { return b.value; });

    function sesuaikan(b) {
        b.style.height = 'auto';
        b.style.height = (b.scrollHeight + 4) + 'px';
    }
    function berubah() {
        return boxes.some(function (b, i) { return b.value !== asli[i]; });
    }
    function mulai() {
        boxes.forEach(function (b) { b.removeAttribute('readonly'); });
        be.style.display = 'none';
        bs.style.display = '';
        bb.style.display = '';
        st.style.display = '';
        boxes[0].focus();
        boxes[0].setSelectionRange(boxes[0].value.length, boxes[0].value.length);
    }
    function batal() {
        if (berubah() && !confirm('Perubahan belum disimpan. Yakin batal?')) { return; }
        boxes.forEach(function (b, i) {
            b.value = asli[i];
            b.setAttribute('readonly', 'readonly');
            sesuaikan(b);
        });
        be.style.display = '';
        bs.style.display = 'none';
        bb.style.display = 'none';
        st.style.display = 'none';
    }

    be.addEventListener('click', mulai);
    bb.addEventListener('click', batal);
    boxes.forEach(function (b) {
        b.addEventListener('input', function () { sesuaikan(b); });
        sesuaikan(b);
    });
    if ({{ $errors->any() ? 'true' : 'false' }}) { mulai(); }
})();
</script>
@endsection