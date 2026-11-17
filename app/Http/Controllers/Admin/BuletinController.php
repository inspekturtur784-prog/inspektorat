<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buletin;
use Illuminate\Http\Request;

class BuletinController extends Controller
{
    public function index()
    {
        $buletins = Buletin::orderByDesc('created_at')->paginate(10);
        return view('admin.buletin.index', compact('buletins'));
    }

    public function create()
    {
        return view('admin.buletin.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->handleCoverUpload($request);
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $this->handlePdfUpload($request);
        }

        Buletin::create($data);

        return redirect()->route('admin.buletin.index')->with('status', 'Buletin berhasil ditambahkan.');
    }

    public function edit(Buletin $buletin)
    {
        return view('admin.buletin.edit', compact('buletin'));
    }

    public function update(Request $request, Buletin $buletin)
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('cover_image')) {
            // Hapus cover lama sebelum diganti
            $this->deleteFiles($buletin, true, false);
            $data['cover_image'] = $this->handleCoverUpload($request);
        }

        if ($request->hasFile('pdf_file')) {
            // Hapus PDF lama sebelum diganti
            $this->deleteFiles($buletin, false, true);
            $data['pdf_file'] = $this->handlePdfUpload($request);
        }

        $buletin->update($data);

        return redirect()->route('admin.buletin.index')->with('status', 'Buletin berhasil diperbarui.');
    }

    public function destroy(Buletin $buletin)
    {
        $this->deleteFiles($buletin);
        $buletin->delete();
        return redirect()->route('admin.buletin.index')->with('status', 'Buletin berhasil dihapus.');
    }

    private function validated(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'title'          => 'required|string|max:255',
            'label'          => 'nullable|string|max:255',
            'image_position' => 'nullable|in:top,center,bottom',
            'theme'          => 'nullable|in:navy,brass,rust,forest',
            'is_published'   => 'nullable|boolean',
            'published_at'   => 'nullable|date',
            'cover_image'    => 'nullable|mimes:jpg,jpeg,png,webp|max:4096',
            // Saat tambah baru, PDF wajib. Saat edit, boleh dikosongkan (pakai PDF lama).
            'pdf_file'       => ($isCreate ? 'required' : 'nullable') . '|file|mimes:pdf|max:20480',
        ]);
    }

    private function handleCoverUpload(Request $request): ?string
    {
        $file = $request->file('cover_image');
        $name = time() . '_' . $this->safeName($file->getClientOriginalName());
        $file->move(public_path('images/buletin'), $name);
        return $name;
    }

    private function handlePdfUpload(Request $request): ?string
    {
        $file = $request->file('pdf_file');
        $name = time() . '_' . $this->safeName($file->getClientOriginalName());
        $file->move(public_path('buletin-pdf'), $name);
        return 'buletin-pdf/' . $name;
    }

    /**
     * Ganti spasi dan karakter aneh pada nama file dengan "-".
     */
    private function safeName(string $name): string
    {
        return preg_replace('/[^A-Za-z0-9._-]/', '-', $name);
    }

    /**
     * Hapus file cover dan/atau PDF milik sebuah buletin dari disk.
     * PDF hanya dihapus jika berada di folder buletin-pdf/ (aman untuk data lama).
     */
    private function deleteFiles(Buletin $buletin, bool $cover = true, bool $pdf = true): void
    {
        if ($cover && $buletin->cover_image) {
            @unlink(public_path('images/buletin/' . $buletin->cover_image));
        }

        if ($pdf && $buletin->pdf_file && str_starts_with($buletin->pdf_file, 'buletin-pdf/')) {
            @unlink(public_path($buletin->pdf_file));
        }
    }
}