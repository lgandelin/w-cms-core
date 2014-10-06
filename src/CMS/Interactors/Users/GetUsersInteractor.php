<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;

class GetUsersInteractor
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($structure = false)
    {
        $users = $this->repository->findAll();

        if ($structure) {
            $userStructures = [];
            if (is_array($users) && sizeof($users) > 0)
                foreach ($users as $user)
                    $userStructures[]= UserStructure::toStructure($user);

            return $userStructures;
        } else
            return $users;
    }
}