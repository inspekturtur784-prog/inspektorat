@if (session('balas_status'))
    <div style="color:#1a7f37;margin-bottom:12px;">{{ session('balas_status') }}</div>
@endif
@if (session('balas_error'))
    <div style="color:#b3261e;margin-bottom:12px;">{{ session('balas_error') }}</div>
@endif
@if ($errors->has('balasan'))
    <div style="color:#b3261e;margin-bottom:12px;">{{ $errors->first('balasan') }}</div>
@endif

<form action="{{ route('admin.pesan.balas', $pesan) }}" method="POST" style="margin-bottom:20px;">
    @csrf
    <div class="form-group">
        <label for="balasan">Balas via Email</label>
        <textarea id="balasan" name="balasan" rows="5" required style="width:100%;">{{ old('balasan') }}</textarea>
        @if ($pesan->dibalas_pada)
            <small style="color:#666;">Terakhir dibalas: {{ \Carbon\Carbon::parse($pesan->dibalas_pada)->format('d F Y, H:i') }} WIB</small>
        @endif
    </div>
    <button type="submit" class="btn-admin">Kirim Balasan</button>
</form>