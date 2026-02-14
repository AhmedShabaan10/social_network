<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $likes = [
            ['user_id' => 1, 'post_id' => 2],
            ['user_id' => 1, 'post_id' => 3],
            ['user_id' => 2, 'post_id' => 1],
            ['user_id' => 2, 'post_id' => 3],
            ['user_id' => 3, 'post_id' => 1],
            ['user_id' => 3, 'post_id' => 2],
        ];

        foreach ($likes as $like) {
            Like::firstOrCreate($like);
        }
    }
}
