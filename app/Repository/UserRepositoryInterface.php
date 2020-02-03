<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;

interface UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool;

    /**
     * @param User $user
     * @return string|null
     */
    public function refreshApiToken(User $user): ?string;

    /**
     * @param Authenticatable $user
     * @return bool
     */
    public function removeApiToken(Authenticatable $user): bool;

    /**
     * @param CanResetPassword $user
     * @param string $password
     * @return mixed
     */
    public function setUserPassword(CanResetPassword $user, string $password): bool;
}
