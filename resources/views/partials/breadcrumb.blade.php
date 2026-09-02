{{--
    Partial Breadcrumb. Cara pakai:

    @include('partials.breadcrumb', [
        'items' => ['Profil' => url('/profil'), 'Data Pegawai' => url('/profil/data-pegawai')],
        'current' => 'Budi Santoso',
    ])

    'items' = link antara (label => url), boleh kosong array [].
    'current' = halaman yang sedang dibuka (tidak dibuat link).
--}}
<nav class="breadcrumb" aria-label="Breadcrumb">
    <div class="wrap">
        <ol>
            <li><a href="{{ url('/') }}">Home</a></li>
            @foreach (($items ?? []) as $label => $link)
                <li><a href="{{ $link }}">{{ $label }}</a></li>
            @endforeach
            @if (!empty($current))
                <li aria-current="page">{{ $current }}</li>
            @endif
        </ol>
    </div>
</nav>