<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::count()) {
            User::create([
                'name' => 'Super admin',
                'email' => 'superadmin@admin.com',
                'username' => 'superadmin@admin.com',
                'phone' => '9544446002',
                'password' => '123456',
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar' => 'user-icon.webp',
                'type' => 'super',
                'created_at' => now(),
            ]);
            User::create([
                'name' => 'Demo User',
                'email' => 'user@admin.com',
                'username' => 'user@admin.com',
                'phone' => '9544446002',
                'password' => '123456',
                'email_verified_at' => '2022-01-02 17:04:58',
                'avatar' => 'user-icon.webp',
                'type' => 'user',
                'created_at' => now(),
            ]);
        }
    }
}
