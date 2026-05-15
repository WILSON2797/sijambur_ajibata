<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\Potency;
use App\Models\News;
use App\Models\Agenda;
use App\Models\Umkm;
use App\Models\Wisata;
use App\Models\Gallery;
use App\Models\VillageSetting;
use Inertia\Inertia;

class WebsiteController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'hero' => PageContent::where('slug', 'hero')->first(),
            'about' => PageContent::where('slug', 'about')->first(),
            'quote' => PageContent::where('slug', 'parallax-1')->first(),
            'potencies' => Potency::latest()->take(4)->get(), 
            'news' => News::latest()->take(3)->get(),
            'settings' => VillageSetting::all()->pluck('value', 'key'),
            'umkm' => Umkm::latest()->take(3)->get(), 
            'wisata' => Wisata::latest()->take(4)->get(), 
            'gallery' => Gallery::latest()->get(),
            'agendas' => Agenda::latest()->take(4)->get(),
            'marqueeItems' => [
                'Desa Pardomuan Ajibata', 'Wisata Danau Toba', 'Budaya Batak Toba', 
                'Pertanian Subur', 'Perikanan Danau', 'Kerajinan Ulos', 'Kecamatan Ajibata'
            ]
        ]);
    }

    public function potency()
    {
        return Inertia::render('Potency/Index', [
            'potencies' => Potency::latest()->get()
        ]);
    }

    public function potencyDetail($slug)
    {
        $potency = Potency::where('slug', $slug)->firstOrFail();
        return Inertia::render('Potency/Show', [
            'potency' => $potency,
            'otherPotencies' => Potency::where('id', '!=', $potency->id)->latest()->take(3)->get()
        ]);
    }

    public function about()
    {
        $about = PageContent::where('slug', 'about')->first();
        return Inertia::render('About/Index', [
            'about' => $about,
            'images' => [
                $about->image ?? 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=900&q=85',
                $about->image_2 ?? 'https://images.unsplash.com/photo-1602867741746-6df80f40b3f6?w=500&q=80',
                $about->image_3 ?? 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&q=80'
            ],
            'pills' => ['🌿 Alam Hijau', '🐟 Danau Toba', '🎭 Budaya Batak', '🌾 Pertanian', '🧵 Tenun Ulos', '🏘️ Adat Istiadat']
        ]);
    }

    public function umkm()
    {
        return Inertia::render('UMKM/Index', [
            'items' => Umkm::latest()->get()
        ]);
    }

    public function wisata()
    {
        return Inertia::render('Wisata/Index', [
            'destinations' => Wisata::latest()->get()
        ]);
    }

    public function gallery()
    {
        return Inertia::render('Gallery/Index', [
            'items' => Gallery::latest()->get()
        ]);
    }

    public function news()
    {
        return Inertia::render('News/Index', [
            'news' => News::latest()->get()
        ]);
    }

    public function contact()
    {
        return back()->with('success', 'Pesan Anda telah terkirim!');
    }
}
