@extends('admin.layout')
@section('title', 'Ganti Kata Sandi')

@section('content')
<div class="admin-header">
    <h1>Ganti Kata Sandi</h1>
</div>

@if(session('success'))
    <div class="alert alert-success" style="margin-bottom: 20px; padding: 10px 15px; background-color: #d4edda; color: #155724; border-radius: 6px;">
        {{ session('success') }}
    </div>
@endif

<form class="admin-form" action="{{ route('admin.password.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="current_password">Kata Sandi Saat Ini</label>
        <input type="password" id="current_password" name="current_password" required>
        @error('current_password')
            <span style="color: red; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Kata Sandi Baru</label>
        <input type="password" id="password" name="password" required>
        @error('password')
            <span style="color: red; font-size: 13px;">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>

    {{-- Checkbox untuk Lihat Kata Sandi --}}
    <div class="form-group" style="margin-top: 10px; margin-bottom: 20px;">
        <label style="display: flex; align-items: center; gap: 8px; font-weight: normal; cursor: pointer; font-size: 14px;">
            <input type="checkbox" id="togglePassword" style="width: auto; cursor: pointer;">
            Tampilkan Kata Sandi
        </label>
    </div>

    <button type="submit" class="btn-admin btn-admin-primary">Perbarui Kata Sandi</button>
</form>

<script>
    document.getElementById('togglePassword').addEventListener('change', function() {
        const isChecked = this.checked;
        const type = isChecked ? 'text' : 'password';
        
        document.getElementById('current_password').type = type;
        document.getElementById('password').type = type;
        document.getElementById('password_confirmation').type = type;
    });
</script>
@endsection