@extends('admin.layout')
@section('title', 'Edit Buletin')

@section('content')
<div class="admin-header"><h1>Edit Buletin</h1></div>

<form action="{{ route('admin.buletin.update', $buletin) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.buletin._form', ['buletin' => $buletin])
    <button type="submit" class="btn-admin btn-admin-primary">Perbarui</button>
</form>
@endsection