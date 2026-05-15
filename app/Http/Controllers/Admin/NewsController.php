<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\CompressesImages;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    use CompressesImages;

    public function index()
    {
        $news = News::latest()->get();
        return Inertia::render('Admin/News/Index', [
            'news' => $news
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'required|image|max:15360',
            'published_at' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->compressAndStore($request->file('image'), 'news');
        }

        News::create($validated);

        return redirect()->back()->with('success', 'Berita berhasil ditambahkan!');
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|max:15360',
            'published_at' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteOldImage($news->image);
            $validated['image'] = $this->compressAndStore($request->file('image'), 'news');
        } else {
            unset($validated['image']);
        }

        $news->update($validated);

        return redirect()->back()->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $news)
    {
        $this->deleteOldImage($news->image);
        $news->delete();
        return redirect()->back()->with('success', 'Berita berhasil dihapus!');
    }
}
