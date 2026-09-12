<?php

namespace Database\Seeders;

use App\Models\ActivityCategory;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivityCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'pengadaan-buku' => [
                ['name' => 'Usulan Buku', 'description' => 'Aktivitas penerimaan dan pencatatan usulan buku.'],
                ['name' => 'Pembelian Buku', 'description' => 'Aktivitas pembelian koleksi buku.'],
                ['name' => 'Hibah Buku', 'description' => 'Aktivitas penerimaan buku dari hibah.'],
                ['name' => 'Penerimaan Buku', 'description' => 'Aktivitas serah terima dan pengecekan buku baru.'],
            ],
            'pengolahan' => [
                ['name' => 'Inventarisasi', 'description' => 'Pencatatan koleksi ke dalam daftar inventaris.'],
                ['name' => 'Klasifikasi', 'description' => 'Penentuan nomor klasifikasi koleksi.'],
                ['name' => 'Katalogisasi', 'description' => 'Input data bibliografi koleksi.'],
                ['name' => 'Labeling', 'description' => 'Pembuatan dan pemasangan label koleksi.'],
                ['name' => 'Shelving', 'description' => 'Penataan koleksi ke rak layanan.'],
            ],
            'layanan' => [
                ['name' => 'Kunjungan', 'description' => 'Pencatatan jumlah kunjungan pemustaka.'],
                ['name' => 'Peminjaman', 'description' => 'Aktivitas peminjaman koleksi.'],
                ['name' => 'Pengembalian', 'description' => 'Aktivitas pengembalian koleksi.'],
                ['name' => 'Referensi', 'description' => 'Layanan bantuan informasi kepada pemustaka.'],
                ['name' => 'Bebas Pustaka', 'description' => 'Layanan administrasi bebas pustaka.'],
                ['name' => 'Literasi Informasi', 'description' => 'Kegiatan pelatihan atau edukasi pemustaka.'],
            ],
            'promosi' => [
                ['name' => 'Instagram', 'description' => 'Promosi melalui Instagram.'],
                ['name' => 'TikTok', 'description' => 'Promosi melalui TikTok.'],
                ['name' => 'Poster', 'description' => 'Pembuatan dan publikasi poster promosi.'],
                ['name' => 'Event', 'description' => 'Kegiatan promosi berbasis acara.'],
                ['name' => 'Kampanye Layanan', 'description' => 'Promosi layanan perpustakaan.'],
            ],
            'digital' => [
                ['name' => 'Digitalisasi', 'description' => 'Pemindaian atau alih media koleksi.'],
                ['name' => 'Repository', 'description' => 'Upload dan pengelolaan repository.'],
                ['name' => 'E-Book', 'description' => 'Pengelolaan koleksi e-book.'],
                ['name' => 'Website', 'description' => 'Update konten website perpustakaan.'],
                ['name' => 'Database Jurnal', 'description' => 'Pengelolaan akses jurnal elektronik.'],
            ],
        ];

        foreach ($data as $moduleSlug => $categories) {
            $module = Module::where('slug', $moduleSlug)->first();

            if (!$module) {
                continue;
            }

            foreach ($categories as $index => $category) {
                ActivityCategory::updateOrCreate(
                    [
                        'module_id' => $module->id,
                        'slug' => Str::of($category['name'])->slug('-'),
                    ],
                    [
                        'name' => $category['name'],
                        'description' => $category['description'],
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}
