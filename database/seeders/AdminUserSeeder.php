<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'sawahbesar@semkot.com'], // kunci unik untuk cek duplikat
            [
                'name' => 'Sawah Besar',             // bisa tambahkan nama
                'password' => bcrypt('sawahbesar0'),
                'is_admin' => true,
            ]
        );
    }
}
