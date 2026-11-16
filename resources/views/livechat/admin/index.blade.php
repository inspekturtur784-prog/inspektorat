@extends('admin.layout')
@section('title', 'Live Chat')

@section('content')
<div class="admin-header">
    <h1>Live Chat</h1>
</div>

@if(session('success'))
    <div style="background:#d1e7dd;color:#0f5132;padding:10px 14px;border-radius:8px;margin-bottom:16px;">{{ session('success') }}</div>
@endif

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;">
    <a href="{{ url('/admin/live-chat') }}" class="btn-admin btn-admin-ghost">Semua</a>
    <a href="{{ url('/admin/live-chat?status=baru') }}" class="btn-admin btn-admin-ghost">Baru</a>
    <a href="{{ url('/admin/live-chat?status=dijawab') }}" class="btn-admin btn-admin-ghost">Dijawab</a>
    <a href="{{ url('/admin/live-chat?status=ditutup') }}" class="btn-admin btn-admin-ghost">Ditutup</a>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Pengguna</th>
            <th>Pesan Terakhir</th>
            <th>Status</th>
            <th>Waktu</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($threads as $t)
            <tr>
                <td>
                    <strong>{{ $t->nama }}</strong>
                    @if($t->unread)
                        <span class="admin-nav-badge" style="margin-left:6px;">{{ $t->unread }}</span>
                    @endif
                    <br>
                    <small>{{ $t->email }}@if($t->telepon) &middot; {{ $t->telepon }}@endif</small>
                </td>
                <td>{{ \Illuminate\Support\Str::limit($t->last_body, 80) }}</td>
                <td>
                    @php
                        $warna = ['baru' => '#dc3545', 'dijawab' => '#198754', 'ditutup' => '#6c757d'][$t->status] ?? '#6c757d';
                    @endphp
                    <span style="display:inline-block;padding:2px 10px;border-radius:999px;font-size:12px;color:#fff;background:{{ $warna }};">{{ ucfirst($t->status) }}</span>
                </td>
                <td>{{ optional($t->last_message_at)->format('d/m/Y H:i') }}</td>
                <td class="row-actions">
                    <a href="{{ url('/admin/live-chat/'.$t->id) }}" class="btn-admin btn-admin-ghost">Buka &amp; Balas</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada live chat masuk.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:20px;">{{ $threads->links() }}</div>
@endsection