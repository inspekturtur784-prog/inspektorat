<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KmsCategory;
use App\Models\KmsDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class KmsDocumentController extends Controller
{
    public function index(KmsCategory $category): View
    {
        $documents = $category->documents()->latest()->get();

        return view('admin.kms.show', compact('category', 'documents'));
    }

    public function store(Request $request, KmsCategory $category): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'tag'   => 'nullable|string|max:100',
            'file'  => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480',
        ]);

        $file = $request->file('file');
        $path = $file->store('kms-documents', 'public');

        $category->documents()->create([
            'title'         => $data['title'],
            'tag'           => $data['tag'] ?? null,
            'file_path'     => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_type'     => strtoupper($file->getClientOriginalExtension()),
        ]);

        return back()->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, KmsDocument $document): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'tag'   => 'nullable|string|max:100',
            'file'  => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:20480',
        ]);

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);

            $file = $request->file('file');
            $data['file_path']     = $file->store('kms-documents', 'public');
            $data['original_name'] = $file->getClientOriginalName();
            $data['file_type']     = strtoupper($file->getClientOriginalExtension());
        }

        $document->update($data);

        return back()->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(KmsDocument $document): RedirectResponse
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(KmsDocument $document)
    {
        $document->increment('views');

        return Storage::disk('public')->download($document->file_path, $document->original_name);
    }
}