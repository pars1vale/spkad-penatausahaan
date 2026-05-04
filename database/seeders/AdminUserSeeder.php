<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'godspkad',
                'nip' => '000000000000000000',
                'password' => bcrypt('12345678'),
            ]
        );

        $user->assignRole('superadmin');
    }
}
