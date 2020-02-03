<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\User;

interface PostRepositoryInterface
{
    /**
     * @param array $data
     * @param User $user
     * @return Post
     */
    public function create(array $data, User $user): Post;

    /**
     * @param Post $post
     * @param array $data
     * @return bool
     */
    public function update(Post $post, array $data): bool;

    /**
     * @param Post $post
     * @return bool
     */
    public function delete(Post $post): bool;
}
