<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{
    use CompressesImages;

    public function index()
    {
        return Inertia::render('Admin/Gallery/Index', [
            'galleries' => Gallery::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'required|image|max:15360',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->compressAndStore($request->file('image'), 'gallery');
        }

        Gallery::create($validated);

        return redirect()->back()->with('success', 'Foto galeri berhasil ditambahkan!');
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:15360',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($gallery->image);
            $validated['image'] = $this->compressAndStore($request->file('image'), 'gallery');
        } else {
            unset($validated['image']);
        }

        $gallery->update($validated);

        return redirect()->back()->with('success', 'Foto galeri berhasil diperbarui!');
    }

    public function destroy(Gallery $gallery)
    {
        $this->deleteOldImage($gallery->image);
        $gallery->delete();
        return redirect()->back()->with('success', 'Foto galeri berhasil dihapus!');
    }
}
