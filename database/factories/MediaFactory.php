<?php

namespace Database\Factories;

use App\Enums\MimeType;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MediaFactory extends Factory
{
    public function definition(): array
    {
        $url = $this->getUrl('post');
        $mime = $this->getMime($url);

        return [
            'url' => $url,
            'mime' => $mime,
            'mediable_id' => Post::factory(),
            'mediable_type' => function (array $att) {
                return Post::find($att['mediable_id'])->getMorphsClass();
            }

        ];
    }

    public function getUrl($type = 'post'): string
    {
        switch ($type) {
            case 'post':

                $urls = [
                    'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                    'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
                    'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                    'https://images.unsplash.com/photo-1683009427500-71296178737f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8',
                    'https://images.unsplash.com/photo-1708861177937-70c66c166609?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw0fHx8ZW58MHx8fHx8',
                    'https://images.unsplash.com/photo-1708936120323-4f34ce5284b3?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHw1fHx8ZW58MHx8fHx8'
                ];
                return $this->faker->randomElement($urls);
                break;

            case 'reel':

                $urls = [
                    'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
                    'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerJoyrides.mp4',
                    'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerMeltdowns.mp4'
                ];
                return $this->faker->randomElement($urls);
                break;
        }
    }

    public function getMime($url): string
    {
        if (Str::contains($url, 'gtv-videos-bucket')) {
            return MimeType::VIDEO->value;
        }

        if (Str::contains($url, 'images.unsplash.com')) {
            return MimeType::IMAGE->value;
        }
    }

    public function reel(): Factory
    {
        $url = $this->getUrl('reel');
        $mime = $this->getMime($url);

        return $this->state(function (array $att) use ($url, $mime) {
            return [
                'mime' => $mime,
                'url' => $url
            ];
        });
    }

    public function post(): Factory
    {
        $url = $this->getUrl('post');
        $mime = $this->getMime($url);

        return $this->state(function (array $att) use ($url, $mime) {
            return [
                'mime' => $mime,
                'url' => $url
            ];
        });
    }
}
