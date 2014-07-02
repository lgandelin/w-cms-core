<?php

namespace CMS\Interactors\Users;

use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;
use CMS\UseCases\Users\CreateUserUseCase;

class CreateUserInteractor implements CreateUserUseCase
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function run(UserStructure $userStructure)
    {
        if (!$userStructure->login)
            throw new \Exception('You must provide a login for a user');

        if ($this->anotherUserExistsWithSameLogin($userStructure->login))
            throw new \Exception('There is already a user with the same login');

        $this->userRepository->createUser($userStructure);
    }

    public function anotherUserExistsWithSameLogin($userLogin)
    {
        return $this->userRepository->findByLogin($userLogin);
    }
} 