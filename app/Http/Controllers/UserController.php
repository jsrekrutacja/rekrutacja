<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Http\Requests\UserPutRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    private $user_repository;

    /**
     * AuthController constructor.
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $per_page = config('pagination.users');

        return UserResource::collection(User::paginate($per_page));
    }

    /**
     * @param UserPostRequest $request
     * @return JsonResponse
     */
    public function store(UserPostRequest $request): JsonResponse
    {
        $user = $this->user_repository->create($request->all());

        return response()->createdJson($user instanceof User);
    }

    /**
     * @param User $user
     * @return JsonResource
     */
    public function show(User $user): JsonResource
    {
        return new UserResource($user);
    }

    /**
     * @param UserPutRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserPutRequest $request, User $user): JsonResponse
    {
        return response()->updatedJson($this->user_repository->update($user, $request->all()));
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user): JsonResponse
    {
        return response()->deletedJson((bool)$user->delete());
    }
}
