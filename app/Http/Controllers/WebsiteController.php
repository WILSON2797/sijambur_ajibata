<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use App\Models\Potency;
use App\Models\News;
use App\Models\VillageOfficial;
use App\Models\Service;
use App\Models\Agenda;
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
            'potencies' => Potency::all(), 
            'news' => News::latest()->get(),
            'settings' => VillageSetting::all()->pluck('value', 'key'),
            'umkm' => $this->getMockUMKM(), 
            'wisata' => $this->getMockWisata(), 
            'marqueeItems' => [
                'Desa Pardomuan Ajibata', 'Wisata Danau Toba', 'Budaya Batak Toba', 
                'Pertanian Subur', 'Perikanan Danau', 'Kerajinan Ulos', 'Kecamatan Ajibata'
            ]
        ]);
    }

    public function potency()
    {
        return Inertia::render('Potency/Index', [
            'potencies' => Potency::all()
        ]);
    }

    public function about()
    {
        return Inertia::render('About/Index', [
            'about' => PageContent::where('slug', 'about')->first(),
            'images' => [
                'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=900&q=85',
                'https://images.unsplash.com/photo-1602867741746-6df80f40b3f6?w=500&q=80',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&q=80'
            ],
            'pills' => ['🌿 Alam Hijau', '🐟 Danau Toba', '🎭 Budaya Batak', '🌾 Pertanian', '🧵 Tenun Ulos', '🏘️ Adat Istiadat']
        ]);
    }

    public function umkm()
    {
        return Inertia::render('UMKM/Index', [
            'items' => $this->getMockUMKM()
        ]);
    }

    public function wisata()
    {
        return Inertia::render('Wisata/Index', [
            'destinations' => $this->getMockWisata()
        ]);
    }

    public function gallery()
    {
        return Inertia::render('Gallery/Index');
    }

    public function news()
    {
        return Inertia::render('News/Index', [
            'news' => News::latest()->get()
        ]);
    }

    public function contact()
    {
        // Handle form submission logic here later
        return back()->with('success', 'Pesan Anda telah terkirim!');
    }

    private function getMockUMKM($limit = null)
    {
        $items = [
            ['name' => 'Tenun Ulos Autentik', 'description' => 'Kerajinan tangan khas Batak Toba dengan motif tradisional.', 'image' => 'https://images.unsplash.com/photo-1609221382720-8a8f1fbf6de3?w=600&q=80'],
            ['name' => 'Kopi Toba Premium', 'description' => 'Kopi arabika pilihan hasil perkebunan warga lokal.', 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80'],
            ['name' => 'Olahan Ikan Danau', 'description' => 'Produk kuliner ikan nila dan mas dari keramba warga.', 'image' => 'https://images.unsplash.com/photo-1548514814-ea62ef1c9e94?w=600&q=80'],
        ];
        return $limit ? array_slice($items, 0, $limit) : $items;
    }

    private function getMockWisata($limit = null)
    {
        $items = [
            ['name' => 'Pantai Pasir Putih', 'description' => 'Tepi danau dengan pasir putih alami dan air yang jernih.', 'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&q=80'],
            ['name' => 'Bukit Hijau Pardomuan', 'description' => 'Spot trekking dengan pemandangan 360 derajat Danau Toba.', 'image' => 'https://images.unsplash.com/photo-1602867741746-6df80f40b3f6?w=800&q=80'],
        ];
        return $limit ? array_slice($items, 0, $limit) : $items;
    }
}
