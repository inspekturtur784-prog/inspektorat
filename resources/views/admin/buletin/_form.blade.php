<div class="form-group">
    <label>Judul Buletin</label>
    <input type="text" name="title" value="{{ old('title', $buletin->title ?? '') }}" required>
</div>

<div class="form-group">
    <label>Label Edisi (mis. EDISI 01 · TRIWULAN I 2026)</label>
    <input type="text" name="label" value="{{ old('label', $buletin->label ?? '') }}">
</div>

<hr style="margin:24px 0;border:none;border-top:1px solid #e5e5e5;">
<h3 style="font-size:15px;margin-bottom:14px;">File PDF Buletin (ditampilkan sebagai flipbook)</h3>

<div class="form-group">
    <label>Upload File PDF</label>
    <input type="file" name="pdf_file" accept="application/pdf" {{ isset($buletin) ? '' : 'required' }}>
    @if(!empty($buletin?->pdf_file))
        <p><small>File saat ini: {{ $buletin->pdf_file }} — kosongkan kalau tidak ingin mengganti.</small></p>
    @endif
</div>

<hr style="margin:24px 0;border:none;border-top:1px solid #e5e5e5;">
<h3 style="font-size:15px;margin-bottom:14px;">Gambar Cover (thumbnail di daftar buletin)</h3>

<div class="form-group">
    <label>Gambar Cover</label>
    <input type="file" name="cover_image" accept="image/*" id="coverInput">
    @if(!empty($buletin?->cover_image))
        <p><small>Gambar saat ini: {{ $buletin->cover_image }}</small></p>
    @endif
</div>

<div class="form-group" style="max-width:220px;">
    <label>Pratinjau Cover</label>
    <div style="position:relative;width:100%;aspect-ratio:3/4;border-radius:8px;overflow:hidden;border:1px solid #ddd;background:#f2f2f2;">
        <img id="coverPreview"
             src="{{ !empty($buletin?->cover_image) ? $buletin->cover_url : asset('images/buletin/placeholder.png') }}"
             style="width:100%;height:100%;object-fit:cover;object-position:{{ $buletin->image_position ?? 'center' }};"
             alt="Pratinjau cover">
    </div>
</div>

<div class="form-group">
    <label>Posisi Gambar Cover</label>
    <select name="image_position" id="imagePositionSelect">
        <option value="top"    {{ old('image_position', $buletin->image_position ?? 'center') == 'top' ? 'selected' : '' }}>Atas</option>
        <option value="center" {{ old('image_position', $buletin->image_position ?? 'center') == 'center' ? 'selected' : '' }}>Tengah</option>
        <option value="bottom" {{ old('image_position', $buletin->image_position ?? 'center') == 'bottom' ? 'selected' : '' }}>Bawah</option>
    </select>
</div>

<div class="form-group">
    <label>Tema Warna Kartu</label>
    <select name="theme" id="themeSelect">
        <option value="navy"   {{ old('theme', $buletin->theme ?? 'navy') == 'navy' ? 'selected' : '' }}>Navy (Biru Tua)</option>
        <option value="brass"  {{ old('theme', $buletin->theme ?? 'navy') == 'brass' ? 'selected' : '' }}>Brass (Emas Tua)</option>
        <option value="rust"   {{ old('theme', $buletin->theme ?? 'navy') == 'rust' ? 'selected' : '' }}>Rust (Merah Bata)</option>
        <option value="forest" {{ old('theme', $buletin->theme ?? 'navy') == 'forest' ? 'selected' : '' }}>Forest (Hijau Tua)</option>
    </select>
    <div id="themeSwatch" style="width:28px;height:28px;border-radius:6px;margin-top:8px;border:1px solid #ccc;"></div>
</div>

<script>
(function () {
    var input = document.getElementById('coverInput');
    var preview = document.getElementById('coverPreview');
    var posSelect = document.getElementById('imagePositionSelect');
    var themeSelect = document.getElementById('themeSelect');
    var swatch = document.getElementById('themeSwatch');
    var themeColors = { navy: '#0f2139', brass: '#b08d57', rust: '#a5462f', forest: '#2f4a3c' };

    function updateSwatch() {
        swatch.style.background = themeColors[themeSelect.value] || themeColors.navy;
    }
    input.addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (file) preview.src = URL.createObjectURL(file);
    });
    posSelect.addEventListener('change', function () {
        preview.style.objectPosition = posSelect.value;
    });
    themeSelect.addEventListener('change', updateSwatch);
    updateSwatch();
})();
</script>

<div class="form-group" style="margin-top:20px;">
    <label><input type="checkbox" name="is_published" value="1" {{ old('is_published', $buletin->is_published ?? true) ? 'checked' : '' }}> Tayangkan</label>
</div>