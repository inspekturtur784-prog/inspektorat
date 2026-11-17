@props(['action', 'konfirmasi' => 'Hapus data ini?'])
<form action="{{ $action }}" method="POST" onsubmit="return confirm({{ \Illuminate\Support\Js::from($konfirmasi) }});">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-icon btn-icon-danger" title="Hapus" aria-label="Hapus">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
    </button>
</form>