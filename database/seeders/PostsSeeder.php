<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::firstOrCreate([
            'user_id' => 1,
        ], [
            'content' => 'Hello, this is my first post!',
        ]);

        Post::firstOrCreate([
            'user_id' => 2,
        ], [
            'content' => 'Hello, this is my first post!',
        ]);

        Post::firstOrCreate([
            'user_id' => 3,
        ], [
            'content' => 'Hello, this is my first post!',
        ]);
    }
}
