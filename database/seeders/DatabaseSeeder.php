<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin user
        $this->call(AdminUserSeeder::class);

        // Buat user biasa (bisa buat testing)
        User::updateOrCreate(
            ['email' => 'sibaikun@human.com'],
            [
                'name' => 'Sibaikun',
                'password' => bcrypt('sibai0'),
                'is_admin' => false,
            ]
        );
    }
}
