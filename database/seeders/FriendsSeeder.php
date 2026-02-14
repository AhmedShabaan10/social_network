<?php

namespace Database\Seeders;

use App\Models\Friend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Friend::firstOrCreate([
            'user_id' => 1,
            'friend_id' => 2,
            'status' => 'accepted',
        ]);

        Friend::firstOrCreate([
            'user_id' => 1,
            'friend_id' => 3,
            'status' => 'accepted',
        ]);

        Friend::firstOrCreate([
            'user_id' => 2,
            'friend_id' => 3,
            'status' => 'accepted',
        ]);
    }
}
