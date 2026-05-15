<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageContent;
use App\Models\Potency;
use App\Models\News;
use App\Models\VillageOfficial;
use App\Models\Service;
use App\Models\Agenda;
use App\Models\VillageSetting;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Page Contents (Hero, About, etc.)
        PageContent::create([
            'slug' => 'hero',
            'title' => 'Desa Pardomuan Ajibata',
            'subtitle' => 'Kecamatan Ajibata · Kabupaten Toba',
            'content' => 'Desa hijau di tepi Danau Toba — menjaga tradisi, membangun masa depan bersama warga yang berdaya.',
            'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=1920&q=90',
            'section' => 'hero'
        ]);

        PageContent::create([
            'slug' => 'about',
            'title' => 'Desa Hijau di Tepi Danau Toba',
            'subtitle' => 'Mengenal Kami',
            'content' => 'Pardomuan Ajibata adalah desa yang terletak di Kecamatan Ajibata, Kabupaten Toba, Sumatera Utara. Berada di tepi Danau Toba — danau vulkanik terbesar di dunia — dikelilingi bukit-bukit hijau dengan udara sejuk sepanjang tahun. Dengan kekayaan budaya Batak Toba yang kental, masyarakat Pardomuan menjaga tradisi adat, kesenian gondang, dan tenun ulos sebagai warisan leluhur yang terus hidup berdampingan dengan kemajuan.',
            'section' => 'about'
        ]);

        PageContent::create([
            'slug' => 'parallax-1',
            'title' => 'Pepatah Warga Pardomuan Ajibata',
            'content' => 'Di mana pun kamu pergi, akar Pardomuan selalu membawamu pulang',
            'section' => 'quote'
        ]);

        // 2. Potencies
        Potency::create([
            'title' => 'Panorama Danau Toba yang Memukau',
            'description' => 'Pemandangan danau vulkanik terbesar di Asia Tenggara. Sunrise dan sunset di tepi desa menjadi daya tarik utama wisatawan nusantara dan mancanegara.',
            'tag' => 'Pariwisata Unggulan',
            'image' => 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&q=80',
            'is_featured' => true
        ]);

        Potency::create([
            'title' => 'Keramba Ikan Mas & Nila',
            'description' => 'Budidaya ikan di Danau Toba sebagai sumber mata pencaharian utama warga.',
            'tag' => 'Perikanan',
            'image' => 'https://images.unsplash.com/photo-1548514814-ea62ef1c9e94?w=600&q=80',
        ]);

        Potency::create([
            'title' => 'Lahan Subur & Kopi Toba',
            'description' => 'Tanah vulkanik menghasilkan kopi, sayuran, dan padi berkualitas tinggi.',
            'tag' => 'Pertanian',
            'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
        ]);

        Potency::create([
            'title' => 'Adat & Kesenian Batak Toba',
            'description' => 'Gondang Sabangunan, Tor-Tor, dan Ulos — warisan budaya yang terus dijaga.',
            'tag' => 'Budaya',
            'image' => 'https://images.unsplash.com/photo-1609221382720-8a8f1fbf6de3?w=600&q=80',
        ]);

        // 3. News
        News::create([
            'title' => 'Festival Budaya Pardomuan 2025 Resmi Dibuka dengan Ribuan Pengunjung',
            'excerpt' => 'Festival tahunan yang memperkenalkan kekayaan adat Batak Toba kepada wisatawan nusantara dan mancanegara kembali digelar dengan meriah di pinggir Danau Toba.',
            'image' => 'https://images.unsplash.com/photo-1602867741746-6df80f40b3f6?w=900&q=80',
            'published_at' => '2025-05-12'
        ]);

        News::create([
            'title' => 'Pembangunan Jalan Lingkar Desa Selesai Lebih Awal dari Jadwal',
            'excerpt' => 'Pembangunan jalan akses utama untuk mempermudah transportasi warga dan wisatawan.',
            'image' => 'https://images.unsplash.com/photo-1593118247619-e2d6f056869e?w=200&q=80',
            'published_at' => '2025-05-03'
        ]);

        // 4. Officials
        VillageOfficial::create([
            'name' => 'Bapak Marojahan Situmorang',
            'position' => 'Kepala Desa',
            'description' => 'Memimpin desa dengan visi "Pardomuan Maju, Warga Sejahtera" dan komitmen kuat terhadap pelestarian budaya lokal.',
            'photo' => 'https://i.pravatar.cc/150?img=52',
            'order' => 1
        ]);

        VillageOfficial::create([
            'name' => 'Ibu Rosmelda Sinaga',
            'position' => 'Sekretaris Desa',
            'photo' => 'https://i.pravatar.cc/150?img=57',
            'order' => 2
        ]);

        // 5. Services
        Service::create([
            'name' => 'Surat Keterangan Domisili',
            'description' => 'Penerbitan surat keterangan tempat tinggal untuk keperluan administrasi resmi.',
            'icon' => 'document'
        ]);

        Service::create([
            'name' => 'Surat Ket. Tidak Mampu',
            'description' => 'Untuk kebutuhan beasiswa, BPJS, dan program bantuan sosial lainnya.',
            'icon' => 'users'
        ]);

        // 6. Agendas
        Agenda::create([
            'title' => 'Musyawarah Desa Perencanaan APBDes 2026',
            'location' => 'Balai Desa',
            'date' => '2025-05-20',
            'time' => '09:00:00'
        ]);

        Agenda::create([
            'title' => 'Posyandu Balita & Lansia Dusun I dan II',
            'location' => 'Polindes Desa',
            'date' => '2025-05-25',
            'time' => '07:30:00'
        ]);

        // 7. Village Settings
        VillageSetting::create(['key' => 'address', 'value' => 'Jl. Raya Pardomuan, Desa Pardomuan, Kec. Ajibata, Kab. Toba, Sumut 22384', 'group' => 'contact']);
        VillageSetting::create(['key' => 'phone', 'value' => '(0632) 123-4567', 'group' => 'contact']);
        VillageSetting::create(['key' => 'email', 'value' => 'desa.pardomuan@ajibata.go.id', 'group' => 'contact']);
        VillageSetting::create(['key' => 'working_hours', 'value' => 'Senin–Jumat: 08.00–15.30 WIB, Sabtu: 08.00–12.00 WIB', 'group' => 'contact']);
        
        VillageSetting::create(['key' => 'stat_population', 'value' => '2.847', 'group' => 'stats']);
        VillageSetting::create(['key' => 'stat_families', 'value' => '712', 'group' => 'stats']);
        VillageSetting::create(['key' => 'stat_area', 'value' => '1.180 Ha', 'group' => 'stats']);
        VillageSetting::create(['key' => 'stat_altitude', 'value' => '904m dpl', 'group' => 'stats']);
    }
}
