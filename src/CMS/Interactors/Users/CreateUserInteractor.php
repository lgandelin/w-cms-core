<?php

namespace CMS\Interactors\Users;

use CMS\Converters\UserConverter;
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
        $user = UserConverter::convertUserStructureToUser($userStructure);

        if ($user->valid()) {
            if ($this->anotherUserExistsWithSameLogin($user->getLogin()))
                throw new \Exception('There is already a user with the same login');

            $this->userRepository->createUser($userStructure);
        }
    }

    public function anotherUserExistsWithSameLogin($userLogin)
    {
        return $this->userRepository->findByLogin($userLogin);
    }
} 