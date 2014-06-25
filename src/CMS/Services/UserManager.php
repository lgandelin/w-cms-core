<?php

namespace CMS\Services;

use CMS\Entities\User;
use CMS\Structures\UserStructure;
use CMS\Repositories\UserRepositoryInterface;

class UserManager {

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getByLogin($login)
    {
        $user = $this->userRepository->findByLogin($login);

        if (!$user)
            throw new \Exception('The user was not found');

        return new UserStructure([
            'login' => $user->getLogin(),
            'password' => $user->getPassword(),
            'last_name' => $user->getLastName(),
            'first_name' => $user->getFirstName(),
            'email' => $user->getEmail()
        ]);
    }
    
    public function getAll()
    {
        return $this->userRepository->findAll();
    }

    public function createUser(UserStructure $userStructure)
    {
        if (!$userStructure->login)
            throw new \InvalidArgumentException('You must provide a login for a user');

        if ($this->userRepository->findByLogin($userStructure->login))
            throw new \Exception('There is already a user with the same login');

        $user = new User();
        $user->setLogin($userStructure->login);
        $user->setPassword($userStructure->password);
        $user->setLastName($userStructure->last_name);
        $user->setFirstName($userStructure->first_name);
        $user->setEmail($userStructure->email);

        return $this->userRepository->createUser($user);
    }

    public function updateUser(UserStructure $userStructure)
    {
        if (!$user = $this->userRepository->findByLogin($userStructure->login))
            throw new \Exception('The user was not found');

        $existingUser = $this->userRepository->findByLogin($user->getLogin());

        if ($existingUser != null && $existingUser->getLogin() != $userStructure->login)
            throw new \Exception('There is already a user with the same login');

        if ($userStructure->password != null && $userStructure->password != $user->getPassword())
            $user->setPassword($userStructure->password);

        $user->setLastName($userStructure->last_name);
        $user->setFirstName($userStructure->first_name);
        $user->setEmail($userStructure->email);

        return $this->userRepository->updateUser($user);
    }

    public function deleteUser($login)
    {
        if (!$user = $this->userRepository->findByLogin($login))
            throw new \Exception('The user was not found');

        return $this->userRepository->deleteUser($user);
    }

}