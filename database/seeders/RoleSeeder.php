<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'description' => 'Akses penuh ke seluruh sistem.',
            ],
            [
                'name' => 'Admin Perpustakaan',
                'slug' => 'admin',
                'description' => 'Mengelola user, master data, aktivitas, dan laporan.',
            ],
            [
                'name' => 'Kepala Perpustakaan',
                'slug' => 'kepala_perpustakaan',
                'description' => 'Monitoring, approval, dan laporan.',
            ],
            [
                'name' => 'Koordinator Bidang',
                'slug' => 'koordinator',
                'description' => 'Review dan monitoring aktivitas sesuai bidang.',
            ],
            [
                'name' => 'Staf',
                'slug' => 'staf',
                'description' => 'Input aktivitas, import data, dan upload bukti.',
            ],
            [
                'name' => 'Viewer',
                'slug' => 'viewer',
                'description' => 'Melihat dashboard dan laporan.',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
