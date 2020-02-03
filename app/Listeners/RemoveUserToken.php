<?php

namespace App\Listeners;

use App\Events\LogoutUser;
use App\Repository\UserRepositoryInterface;

class RemoveUserToken
{
    private $repository;

    /**
     * RemoveUserToken constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LogoutUser $event
     */
    public function handle(LogoutUser $event):void
    {
        $this->repository->removeApiToken($event->getUser());
    }
}
