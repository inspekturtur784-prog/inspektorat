@extends('admin.layout')
@section('title', 'Tambah Buletin')

@section('content')
<div class="admin-header"><h1>Tambah Buletin</h1></div>

<form action="{{ route('admin.buletin.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('admin.buletin._form', ['buletin' => null])
    <button type="submit" class="btn-admin btn-admin-primary">Simpan</button>
</form>
@endsection