<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\User;

class PostRepository implements PostRepositoryInterface
{
    /**
     * @param array $data
     * @param User $user
     * @return Post
     */
    public function create(array $data, User $user): Post
    {
        $data['user_id'] = $user->id;

        return Post::create($data);
    }

    /**
     * @param Post $post
     * @param array $data
     * @return bool
     */
    public function update(Post $post, array $data): bool
    {
        $post->fill($data);

        return $post->save();
    }

    /**
     * @param Post $post
     * @return bool
     * @throws \Exception
     */
    public function delete(Post $post): bool
    {
        return (bool)$post->delete();
    }
}
