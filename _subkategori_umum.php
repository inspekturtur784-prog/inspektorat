<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$kosong = App\Models\Kategori::doesntHave('subkategoris')->orderBy('nama')->get();
if ($kosong->isEmpty()) { echo "Semua kategori sudah punya subkategori.\n"; exit; }

if (getenv('KMS_BUAT') !== 'y') {
    echo "Kategori tanpa subkategori:\n";
    foreach ($kosong as $k) { echo " - {$k->nama}\n"; }
    exit;
}
foreach ($kosong as $k) {
    App\Models\Subkategori::create([
        'kategori_id' => $k->id,
        'nama' => 'Umum',
        'slug' => Illuminate\Support\Str::slug('Umum') . '-' . uniqid(),
    ]);
    echo "Dibuat: {$k->nama} / Umum\n";
}