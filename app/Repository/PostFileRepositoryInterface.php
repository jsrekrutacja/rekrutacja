<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\PostFiles;
use Symfony\Component\HttpFoundation\File\File;

interface PostFileRepositoryInterface
{
    /**
     * @param File $file
     * @param Post $post
     * @return PostFiles
     */
    public function create(File $file, Post $post): PostFiles;
}
