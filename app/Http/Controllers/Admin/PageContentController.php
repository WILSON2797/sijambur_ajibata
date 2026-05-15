<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageContentController extends Controller
{
    use CompressesImages;

    public function index()
    {
        $pages = PageContent::all();
        return Inertia::render('Admin/PageContent/Index', [
            'pages' => $pages
        ]);
    }

    public function edit(PageContent $page)
    {
        return Inertia::render('Admin/PageContent/Edit', [
            'pageContent' => $page // Changed variable name to avoid conflict with $page global
        ]);
    }

    public function update(Request $request, PageContent $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:15360',
            'image_2' => 'nullable|image|max:15360',
            'image_3' => 'nullable|image|max:15360',
        ]);

        foreach (['image', 'image_2', 'image_3'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $this->deleteOldImage($page->$imgField);
                $validated[$imgField] = $this->compressAndStore($request->file($imgField), 'pages');
            } else {
                unset($validated[$imgField]);
            }
        }

        $page->update($validated);

        return redirect()->back()->with('success', 'Konten berhasil diperbarui!');
    }
}
