<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Support\Str;

class PostRepository
{

    public function createPost(array $postData): Post
    {
        $post = Post::create([
            'user_id' => $postData['user_id'],
            'description' => $postData['description'],
            'location' => $postData['location'],
            'allow_commenting' => $postData['allow_commenting'],
            'hide_like_view' => $postData['hide_like_view'],
            'type' => $postData['type']
        ]);

        return $post;
    }
}
