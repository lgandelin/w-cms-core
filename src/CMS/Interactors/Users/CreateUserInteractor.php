<?php

namespace CMS\Interactors\Users;

use CMS\Converters\UserConverter;
use CMS\Repositories\UserRepositoryInterface;
use CMS\Structures\UserStructure;

class CreateUserInteractor
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

            return $this->userRepository->createUser(UserConverter::convertUserToUserStructure($user));
        }
    }

    public function anotherUserExistsWithSameLogin($userLogin)
    {
        return $this->userRepository->findByLogin($userLogin);
    }
} 