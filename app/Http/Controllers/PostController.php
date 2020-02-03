<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostPostRequest;
use App\Http\Requests\PostPutRequest;
use App\Http\Requests\UploadMediaPostResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use App\Repository\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class PostController extends Controller
{
    private $post_repository;

    /**
     * PostController constructor.
     * @param PostRepositoryInterface $post_repository
     */
    public function __construct(PostRepositoryInterface $post_repository)
    {
        $this->post_repository = $post_repository;
    }

    /**
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $per_page = config('pagination.users');

        return PostResource::collection(Post::with('users')->paginate($per_page));
    }

    /**
     * @param PostPostRequest $request
     * @return JsonResponse
     */
    public function store(PostPostRequest $request): JsonResponse
    {
        $user = auth()->user();

        if ($user instanceof User) {
            $post = $this->post_repository->create($request->all(), $user);
        }

        return response()->createdJson(isset($post) && $post instanceof Post);
    }

    /**
     * @param Post $post
     * @return JsonResource
     */
    public function show(Post $post): JsonResource
    {
        return new PostResource($post);
    }

    /**
     * @param PostPutRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(PostPutRequest $request, Post $post): JsonResponse
    {
        return response()->updatedJson($this->post_repository->update($post, $request->all()));
    }

    /**
     * @param Post $post
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Post $post): JsonResponse
    {
        return response()->deletedJson($this->post_repository->delete($post));
    }
}
