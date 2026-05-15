<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Potency;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class PotencyController extends Controller
{
    use CompressesImages;

    public function index()
    {
        return Inertia::render('Admin/Potency/Index', [
            'potencies' => Potency::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tag' => 'nullable|string|max:100',
            'image' => 'required|image|max:15360',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->compressAndStore($request->file('image'), 'potencies');
        }

        $validated['slug'] = Str::slug($validated['title']);

        Potency::create($validated);

        return redirect()->back()->with('success', 'Potensi berhasil ditambahkan!');
    }

    public function update(Request $request, Potency $potency)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'tag' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:15360',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($potency->image);
            $validated['image'] = $this->compressAndStore($request->file('image'), 'potencies');
        } else {
            unset($validated['image']);
        }

        $validated['slug'] = Str::slug($validated['title']);

        $potency->update($validated);

        return redirect()->back()->with('success', 'Potensi berhasil diperbarui!');
    }

    public function destroy(Potency $potency)
    {
        $this->deleteOldImage($potency->image);
        $potency->delete();
        return redirect()->back()->with('success', 'Potensi berhasil dihapus!');
    }
}
