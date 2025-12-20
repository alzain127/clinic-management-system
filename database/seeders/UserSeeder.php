<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'المدير العام',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'مدير',
        ]);

        // Create Staff User
        User::create([
            'name' => 'موظف الاستقبال',
            'email' => 'user@admin.com',
            'password' => Hash::make('password'),
            'role' => 'موظف',
        ]);
    }
}
