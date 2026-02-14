<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ahmed Ali',
                'email' => 'ahmed@example.com',
                'password' => Hash::make('123456789'),
            ],
            [
                'name' => 'Sara Mohamed',
                'email' => 'sara@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Mostafa Gamal',
                'email' => 'mostafa@example.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
