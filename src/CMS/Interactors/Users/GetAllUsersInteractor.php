<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;

class GetAllUsersInteractor
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->findAll();
    }
}