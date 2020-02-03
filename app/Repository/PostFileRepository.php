<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\PostFiles;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

class PostFileRepository implements PostFileRepositoryInterface
{
    private $disk = 'public';

    /**
     * @param File $file
     * @param Post $post
     * @return PostFiles
     */
    public function create(File $file, Post $post): PostFiles
    {
        $file_name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        Storage::disk($this->disk)->putFileAs('/', $file, $file_name);

        return PostFiles::create(['name' => $file_name, 'disk' => $this->disk, 'post_id' => $post->id]);
    }
}
