<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('slug', 'super_admin')->first();

        User::updateOrCreate(
            ['email' => 'fauzanshidqi21@gmail.com'],
            [
                'role_id' => $superAdminRole?->id,
                'name' => 'Super Admin',
                'password' => Hash::make(Str::random(32)),
                'is_active' => true,
            ]
        );
    }
}
