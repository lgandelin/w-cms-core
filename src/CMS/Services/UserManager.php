<?php

namespace CMS\Services;

use CMS\Converters\UserConverter;
use CMS\Entities\User;
use CMS\Structures\UserStructure;
use CMS\Repositories\UserRepositoryInterface;

class UserManager {

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->userConverter = new UserConverter();
    }

    public function getByLogin($login)
    {
        $user = $this->userRepository->findByLogin($login);

        if (!$user)
            throw new \Exception('The user was not found');

        return $this->userConverter->convertUserToUserStructure($user);
    }
    
    public function getAll()
    {
        $users = $this->userRepository->findAll();

        $usersS = [];
        if (is_array($users) && sizeof($users) > 0) {
            foreach ($users as $i => $user) {
                $usersS[]= $this->userConverter->convertUserToUserStructure($user);
            }

            return $usersS;
        }

        return false;
    }

    public function createUser(UserStructure $userStructure)
    {
        if (!$userStructure->login)
            throw new \InvalidArgumentException('You must provide a login for a user');

        if ($this->userRepository->findByLogin($userStructure->login))
            throw new \Exception('There is already a user with the same login');

        $user = $this->userConverter->convertUserStructureToUser($userStructure);

        return $this->userRepository->createUser($user);
    }

    public function updateUser(UserStructure $userStructure)
    {
        if (!$user = $this->userRepository->findByLogin($userStructure->login))
            throw new \Exception('The user was not found');

        $existingUser = $this->userRepository->findByLogin($user->getLogin());

        if ($existingUser != null && $existingUser->getLogin() != $userStructure->login)
            throw new \Exception('There is already a user with the same login');

        $user = $this->userConverter->convertUserStructureToUser($userStructure);

        return $this->userRepository->updateUser($user);
    }

    public function deleteUser($login)
    {
        if (!$user = $this->userRepository->findByLogin($login))
            throw new \Exception('The user was not found');

        return $this->userRepository->deleteUser($user);
    }

}