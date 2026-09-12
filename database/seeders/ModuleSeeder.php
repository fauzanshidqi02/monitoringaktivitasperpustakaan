<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'name' => 'Pengadaan Buku',
                'slug' => 'pengadaan-buku',
                'description' => 'Aktivitas usulan, pembelian, hibah, dan penerimaan buku.',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pengolahan',
                'slug' => 'pengolahan',
                'description' => 'Aktivitas inventarisasi, klasifikasi, katalogisasi, labeling, dan shelving.',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Layanan',
                'slug' => 'layanan',
                'description' => 'Aktivitas layanan sirkulasi, referensi, kunjungan, dan bebas pustaka.',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Promosi',
                'slug' => 'promosi',
                'description' => 'Aktivitas promosi perpustakaan, media sosial, poster, dan event.',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Digital',
                'slug' => 'digital',
                'description' => 'Aktivitas digitalisasi, repository, e-resource, website, dan konten digital.',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($modules as $module) {
            Module::updateOrCreate(
                ['slug' => $module['slug']],
                $module
            );
        }
    }
}
