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
            $data['cover_image'] = $this->handleCoverUpload($request);
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $this->handlePdfUpload($request);
        }

        $buletin->update($data);

        return redirect()->route('admin.buletin.index')->with('status', 'Buletin berhasil diperbarui.');
    }

    public function destroy(Buletin $buletin)
    {
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
            'cover_image'    => 'nullable|image|max:4096',
            // Saat tambah baru, PDF wajib. Saat edit, boleh dikosongkan (pakai PDF lama).
            'pdf_file'       => ($isCreate ? 'required' : 'nullable') . '|file|mimes:pdf|max:20480',
        ]);
    }

    private function handleCoverUpload(Request $request): ?string
    {
        $file = $request->file('cover_image');
        $name = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/buletin'), $name);
        return $name;
    }

    private function handlePdfUpload(Request $request): ?string
    {
        $file = $request->file('pdf_file');
        $name = time() . '_' . preg_replace('/\s+/', '-', $file->getClientOriginalName());
        $file->move(public_path('buletin-pdf'), $name);
        return $name;
    }
}