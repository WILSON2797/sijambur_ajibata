<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UmkmController extends Controller
{
    use CompressesImages;

    public function index()
    {
        return Inertia::render('Admin/Umkm/Index', [
            'umkms' => Umkm::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'image' => 'required|image|max:15360',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->compressAndStore($request->file('image'), 'umkms');
        }

        Umkm::create($validated);

        return redirect()->back()->with('success', 'UMKM berhasil ditambahkan!');
    }

    public function update(Request $request, Umkm $umkm)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'image' => 'nullable|image|max:15360',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($umkm->image);
            $validated['image'] = $this->compressAndStore($request->file('image'), 'umkms');
        } else {
            unset($validated['image']);
        }

        $umkm->update($validated);

        return redirect()->back()->with('success', 'UMKM berhasil diperbarui!');
    }

    public function destroy(Umkm $umkm)
    {
        $this->deleteOldImage($umkm->image);
        $umkm->delete();
        return redirect()->back()->with('success', 'UMKM berhasil dihapus!');
    }
}
