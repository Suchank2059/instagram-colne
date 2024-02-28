<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(20)->create(['type' => 'reel']);
        Post::factory(rand(10, 40))->create(['type' => 'post']);
    }
}
