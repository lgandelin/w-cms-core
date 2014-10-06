<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;

class GetUserInteractor
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getUserByID($userID, $structure = false)
    {
        $user = $this->repository->findByID($userID);

        if (!$user)
            throw new \Exception('The user was not found');

        return  ($structure) ? UserStructure::toStructure($user) : $user;
    }

}