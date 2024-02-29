<?php

namespace App\Repository;

use App\Enums\MimeType;
use App\Models\Media;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaRepository
{
    #add media
    public function addMedia(array $media, int $id, string $mediable_type)
    {
        foreach ($media as $key => $file) {

            #get mime type
            $mime = $this->getMime($file);

            #save to storage
            $path = $file->store('media', 'public');

            #get Url
            $url = url(Storage::url($path));

            #create media
            Media::create([
                'url' => $url,
                'mime' => $mime,
                'mediable_id' => $id,
                'mediable_type' => $mediable_type
            ]);
        }
    }

    #get mime type
    public function getMime($media): string
    {
        return Str::contains($media->getMimeType(), MimeType::VIDEO->value)
            ? MimeType::VIDEO->value : MimeType::IMAGE->value;
    }
}
