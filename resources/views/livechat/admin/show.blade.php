@extends('admin.layout')
@section('title', 'Live Chat - ' . $thread->nama)

@section('content')
<style>
.lc-box{max-width:780px}
.lc-info{color:#555;font-size:14px;margin:4px 0 16px}
.lc-msgs{height:400px;overflow:auto;background:#f3f5f9;border-radius:10px;padding:14px;border:1px solid #e3e6ee}
.lc-m{max-width:78%;margin-bottom:10px;padding:9px 12px;border-radius:12px;white-space:pre-wrap;word-wrap:break-word;line-height:1.5}
.lc-m.user{background:#fff;border:1px solid #dde}
.lc-m.admin{margin-left:auto;background:#0d6efd;color:#fff}
.lc-m small{display:block;opacity:.65;font-size:11px;margin-top:4px}
.lc-reply textarea{width:100%;box-sizing:border-box;border:1px solid #ccd;border-radius:10px;padding:10px;font:inherit;min-height:90px;margin-top:14px}
.lc-actions{display:flex;gap:10px;align-items:center;margin-top:10px;flex-wrap:wrap}
</style>

<div class="admin-header">
    <h1>Live Chat</h1>
</div>

<div class="lc-box">
    <a href="{{ url('/admin/live-chat') }}" class="btn-admin btn-admin-ghost">&larr; Kembali ke Live Chat</a>

    <h2 style="margin:18px 0 0;">{{ $thread->nama }}</h2>
    <div class="lc-info">
        {{ $thread->email }}@if($thread->telepon) &middot; {{ $thread->telepon }}@endif
        &middot; Status: <strong>{{ ucfirst($thread->status) }}</strong>
    </div>

    @if(session('success'))
        <div style="background:#d1e7dd;color:#0f5132;padding:10px 14px;border-radius:8px;margin-bottom:14px;">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div style="background:#f8d7da;color:#842029;padding:10px 14px;border-radius:8px;margin-bottom:14px;">{{ $errors->first() }}</div>
    @endif

    <div class="lc-msgs" id="lc-msgs">
        @foreach($messages as $m)
            <div class="lc-m {{ $m->sender }}">{{ $m->body }}<small>{{ $m->sender === 'admin' ? 'Admin' : $thread->nama }} - {{ $m->created_at->format('d/m/Y H:i') }}</small></div>
        @endforeach
    </div>

    @if($thread->status !== 'ditutup')
        <form method="POST" action="{{ url('/admin/live-chat/'.$thread->id.'/reply') }}" class="lc-reply">
            @csrf
            <textarea name="pesan" placeholder="Tulis balasan... (pengguna akan menerima email pemberitahuan)" required></textarea>
            <div class="lc-actions">
                <button type="submit" class="btn-admin">Kirim Balasan</button>
            </div>
        </form>

        <form method="POST" action="{{ url('/admin/live-chat/'.$thread->id.'/close') }}" style="margin-top:10px;" onsubmit="return confirm('Tutup konsultasi ini?');">
            @csrf
            <button type="submit" class="btn-admin btn-admin-danger">Tutup Konsultasi</button>
        </form>
    @else
        <p style="margin-top:16px;"><em>Konsultasi ini sudah ditutup.</em></p>
    @endif
</div>

<script>
(function () {
    var box = document.getElementById('lc-msgs');
    var last = {{ (int) optional($messages->last())->id }};
    var namaUser = @json($thread->nama);
    box.scrollTop = box.scrollHeight;

    function add(m) {
        if (m.id <= last) return;
        last = m.id;
        var d = document.createElement('div');
        d.className = 'lc-m ' + m.sender;
        d.textContent = m.body;
        var s = document.createElement('small');
        s.textContent = (m.sender === 'admin' ? 'Admin' : namaUser) + ' - ' + m.time;
        d.appendChild(s);
        box.appendChild(d);
        box.scrollTop = box.scrollHeight;
    }

    setInterval(function () {
        fetch('{{ url('/admin/live-chat/'.$thread->id.'/messages') }}?after=' + last, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (r) { return r.json(); }).then(function (j) {
            j.messages.forEach(add);
        }).catch(function () {});
    }, 5000);
})();
</script>
@endsection