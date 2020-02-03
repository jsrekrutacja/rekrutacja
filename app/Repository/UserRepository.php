<?php

namespace App\Repository;

use App\Events\LogoutUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);
    }

    /**
     * @param User $user
     * @param array $data
     * @return bool
     */
    public function update(User $user, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
            event(new LogoutUser($user));
        }
        $user->fill($data);

        return $user->save();
    }


    /**
     * @param User $user
     * @return string|null
     */
    public function refreshApiToken(User $user): ?string
    {
        $token = hash('sha256', Str::random(60));

        return $user->forceFill(['api_token' => $token])->save() ? $token : null;
    }

    /**
     * @param Authenticatable $user
     * @return bool
     */
    public function removeApiToken(Authenticatable $user): bool
    {
        $user->api_token = null;

        return $user->save();
    }

    /**
     * @param CanResetPassword $user
     * @param string $password
     * @return bool
     */
    public function setUserPassword(CanResetPassword $user, string $password): bool
    {
        $user->password = Hash::make($password);
        event(new LogoutUser($user));

        return $user->save();
    }
}
