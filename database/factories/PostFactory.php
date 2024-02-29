<?php

namespace Database\Factories;

use App\Enums\PostType;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'description' => fake()->text(),
            'location' => fake()->city(),
            'hide_like_view' => fake()->boolean(),
            'allow_commenting' => fake()->boolean(),
            'type' => 'post'
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Post $post) {
            if ($post->type == PostType::REEL->value) {
                Media::factory()->reel()->create(['mediable_type' => get_class($post), 'mediable_id' => $post->id]);
            } else {
                Media::factory()->post()->create(['mediable_type' => get_class($post), 'mediable_id' => $post->id]);
            }
        });
    }
}
