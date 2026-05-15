<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WisataController extends Controller
{
    use CompressesImages;

    public function index()
    {
        return Inertia::render('Admin/Wisata/Index', [
            'wisatas' => Wisata::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'required|image|max:15360',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->compressAndStore($request->file('image'), 'wisata');
        }

        Wisata::create($validated);

        return redirect()->back()->with('success', 'Wisata berhasil ditambahkan!');
    }

    public function update(Request $request, Wisata $wisata)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:15360',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($wisata->image);
            $validated['image'] = $this->compressAndStore($request->file('image'), 'wisata');
        } else {
            unset($validated['image']);
        }

        $wisata->update($validated);

        return redirect()->back()->with('success', 'Wisata berhasil diperbarui!');
    }

    public function destroy(Wisata $wisata)
    {
        $this->deleteOldImage($wisata->image);
        $wisata->delete();
        return redirect()->back()->with('success', 'Wisata berhasil dihapus!');
    }
}
