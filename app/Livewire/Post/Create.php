<?php

namespace App\Livewire\Post;

use App\Enums\MimeType;
use App\Enums\PostType;
use App\Models\Post;
use App\Repository\MediaRepository;
use App\Repository\PostRepository;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Support\Str;

class Create extends ModalComponent
{

    use WithFileUploads;

    public $media = [];
    public $description;
    public $location;
    public $hide_like_view = false;
    public $allow_commenting = false;

    protected $rules = [
        'media.*' => 'required|file|mimes:png.jpg,jpeg,mp4,mov|max:100000',
        'allow_commenting' => 'boolean',
        'hide_like_view' => 'boolean',
    ];


    public static function modalMaxWidth(): string
    {
        return '4xl';
    }

    public function submit(PostRepository $createPost, MediaRepository $addMedia)
    {
        #validate
        $this->validate();

        #determine if reel or post
        $type = $this->getPostType($this->media);

        #array of data to create post
        $postData  = [
            'user_id' => auth()->user()->id,
            'description' => $this->description,
            'location' => $this->location,
            'allow_commenting' => $this->allow_commenting,
            'hide_like_view' => $this->hide_like_view,
            'type' => $type
        ];

        #create Post
        $post = $createPost->createPost($postData);

        #add media
        $addMedia->addMedia($this->media, $post->id, Post::class);

        $this->reset();
        $this->dispatch('close');

        #dispatch event for post created
        $this->dispatch('post-created', $post->id);
    }

    public function render()
    {
        return view('livewire.post.create');
    }

    public function getPostType($media): string
    {
        if (count($media) === 1 && Str::contains($media[0]->getMimeType(), MimeType::VIDEO->value)) {
            return PostType::REEL->value;
        } else {
            return PostType::POST->value;
        }
    }
}
