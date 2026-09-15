<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KmsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KmsCategoryController extends Controller
{
    public function index(): View
    {
        $categories = KmsCategory::withCount('documents')->latest()->get();

        return view('admin.kms.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
        ]);

        KmsCategory::create($data);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KmsCategory $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
        ]);

        $category->update($data);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KmsCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'Kategori dan seluruh dokumennya berhasil dihapus.');
    }
}