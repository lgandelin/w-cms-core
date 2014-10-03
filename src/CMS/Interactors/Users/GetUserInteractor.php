<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;

class GetUserInteractor
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByID($userID)
    {
        $user = $this->repository->findByID($userID);

        if (!$user)
            throw new \Exception('The user was not found');

        return $user;
    }

}