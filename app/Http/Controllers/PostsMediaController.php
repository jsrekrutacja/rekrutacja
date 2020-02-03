<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadMediaPostResource;
use App\Models\Post;
use App\Repository\PostFileRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostsMediaController extends Controller
{
    private $post_file_repository;

    /**
     * PostsMediaController constructor.
     * @param PostFileRepositoryInterface $post_file_repository
     */
    public function __construct(PostFileRepositoryInterface $post_file_repository)
    {
        $this->post_file_repository = $post_file_repository;
    }

    /**
     * @param UploadMediaPostResource $request
     * @param Post $post
     * @return JsonResponse
     */
    public function store(UploadMediaPostResource $request, Post $post): JsonResponse
    {
        $files = $request->file('media');

        foreach ($files as $file) {
            $this->post_file_repository->create($file, $post);
        }

        return response()->createdJson(true);
    }
}
